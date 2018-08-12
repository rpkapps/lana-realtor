<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class VoyagerListingController extends BaseVoyagerBreadController
{
    /**
     * GET (B)READ - Browse data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? [
            'id',
            'asking_price',
            'street_number',
            'street_name',
            'city',
            'state',
            'zip_code',
            'elementary_school',
            'high_school',
            'parking_spaces',
            'beds',
            'total_baths',
            'garage_spaces',
            'residence_sqft',
            'additional_street_info',
            'rent_date_available'
        ] : '';
        $orderBy = $request->get('order_by');
        $sortOrder = $request->get('sort_order', null);

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model::select('*');

            $query->whereNull('mls_id');

            $relationships = $this->getRelationships($dataType);

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $query->where($search->key, $search_filter, $search_value);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'DESC';
                $dataTypeContent = call_user_func([
                    $query->with($relationships)->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->with($relationships)->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        if (($isModelTranslatable = is_bread_translatable($model))) {
            $dataTypeContent->load('translations');
        }

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'sortOrder',
            'searchable',
            'isServerSide'
        ));
    }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        // Populate full address
        $request->merge([
            'full_address' => $request->get('street_number') . ' ' . $request->get('street_name')
        ]);

        // Populate Latitude and Longitude
         $this->setGeoCoordinatesFromGoogleAPI($request);

        if (!$request->ajax()) {
            $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

            // Update photos and thumbnails
            if($data->photos) {
                $thumbnails = array_map(function($photo) {
                    $extensionPos = strrpos($photo, '.');
                    return substr($photo, 0, $extensionPos) . '-small' . substr($photo, $extensionPos);
                }, json_decode($data->photos));

                $data->thumbnails = json_encode($thumbnails);
                $data->save();
            }

            event(new BreadDataAdded($dataType, $data));

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager.generic.successfully_added_new')." {$dataType->display_name_singular}",
                    'alert-type' => 'success',
                ]);
        }
    }

    /**
     * PATCH BR(E)AD - Update data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id) {
        if (!Auth::user()->hasPermission('edit_roles')) {
            unset($request['role_id']);
        }

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $slug, $id);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        // Populate full address
        $request->merge([
            'full_address' => $request->get('street_number') . ' ' . $request->get('street_name')
        ]);

        // Update latitude and longitude
        if($request->get('full_address') !== $data->full_address || $request->get('city') !== $data->city) {
            $this->setGeoCoordinatesFromGoogleAPI($request);
        }

        if (!$request->ajax()) {
            $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

            // Update photos and thumbnails
            if($data->photos) {
                $thumbnails = array_map(function($photo) {
                    $extensionPos = strrpos($photo, '.');
                    return substr($photo, 0, $extensionPos) . '-small' . substr($photo, $extensionPos);
                }, json_decode($data->photos));

                $data->thumbnails = json_encode($thumbnails);
                $data->save();
            }

            event(new BreadDataUpdated($dataType, $data));

            if($slug === 'users') {
                return redirect()->back();
            }

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager.generic.successfully_updated')." {$dataType->display_name_singular}",
                    'alert-type' => 'success',
                ]);
        }
    }

    /**
     * Set geo coordinates from Google Maps API
     *
     * @param Request $request
     * @return array
     */
    protected function setGeoCoordinatesFromGoogleAPI(Request &$request)
    {
        try {
            $address = $request->get('full_address') . ', ' . $request->get('city') . ', ' . $request->get('state');
            $geo = app('geocoder')->geocode($address)->get()->first();

            if ($geo) {
                $coordinates = $geo->getCoordinates();

                $request->merge([
                    'latitude' => $coordinates->getLatitude(),
                    'longitude' => $coordinates->getLongitude()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Geocode failed: ' . $e->getMessage());
        }
    }
}
