<?php

namespace App\Http\Controllers;

use App\Http\Resources\MinimalListingResource;
use Illuminate\Http\Request;
use App\Listing;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ListingResource;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    /**
     * Display for sale listings
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function buyIndex(Request $request)
    {
        // Pagination limit per page
        $limit = $request->query('limit', 12);

        $query = Listing::query();

        $query->where('sale_rent', 'For Sale');

        $this->addSortAndFilters($request, $query);

        return MinimalListingResource::collection($query->paginate($limit));
    }

    /**
     * Display for rent listings
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function rentIndex(Request $request)
    {
        // Pagination limit per page
        $limit = $request->query('limit', 12);

        $query = Listing::query();

        $query->where('sale_rent', 'For Rent');

        $this->addSortAndFilters($request, $query);

        return MinimalListingResource::collection($query->paginate($limit));
    }

    /**
     * Find for sale listings for map
     *
     * @param Request $request
     */
    public function buyMap(Request $request)
    {
        $query = Listing::where('sale_rent', 'For Sale');
        $this->addSortAndFilters($request, $query);

        return MinimalListingResource::collection($query->get());
    }

    /**
     * Find for rent listings for map
     *
     * @param Request $request
     */
    public function sellMap(Request $request)
    {
        $query = Listing::where('sale_rent', 'For Sale');
        $this->addSortAndFilters($request, $query);

        return MinimalListingResource::collection($query->get());
    }

    /**
     * Display featured listings
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function featuredIndex(Request $request)
    {
        $listings = Listing::orderBy('updated_at', 'desc')
            ->take(12)
            ->get();

        return MinimalListingResource::collection($listings);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Listing $listing
     * @return ListingResource
     */
    public function show(Listing $listing)
    {
        return new ListingResource($listing);
    }

    /**
     * Add sorting and filtering to query
     *
     * @param Request $request
     * @param Builder $query
     */
    protected function addSortAndFilters(Request $request, Builder $query)
    {
        // Search query
        $query->search($request->query('q'));

        // Type Filter
        $this->multiSelectFilter($query, 'type', $request->get('type'));

        // Min Price
        $this->minFilter($query, 'asking_price', $request->get('minprice'));

        // Max Price
        $this->maxFilter($query, 'asking_price', $request->get('maxprice'));

        // Min Area
        $this->minFilter($query, 'residence_sqft', $request->get('minarea'));

        // Max Area
        $this->maxFilter($query, 'residence_sqft', $request->get('maxarea'));

        // Min Bedrooms
        $this->minFilter($query, 'beds', $request->get('minbeds'));

        // Max Bedrooms
        $this->maxFilter($query, 'beds', $request->get('maxbeds'));

        // Min Bathrooms
        $this->minFilter($query, 'total_baths', $request->get('minbaths'));

        // Min Bathrooms
        $this->maxFilter($query, 'total_baths', $request->get('maxbaths'));

        // Sort
        $this->sort($query, $request->get('sort'));
    }

    /**
     * Multi select filter helper
     *
     * @param Builder $query
     * @param $column
     * @param $values
     */
    protected function multiSelectFilter(Builder $query, $column, $values)
    {
        if (is_array($values) && count($values) > 0) {
            $query->whereIn($column, $values);
        }
    }

    /**
     * Min filter helper
     *
     * @param Builder $query
     * @param string $column
     * @param $value
     */
    protected function minFilter(Builder $query, $column = '', $value)
    {
        $value = intval($value);
        if ($value) {
            $query->where($column, '>=', $value);
        }
    }

    /**
     * Max filter helper
     *
     * @param Builder $query
     * @param string $column
     * @param $value
     */
    protected function maxFilter(Builder $query, $column = '', $value)
    {
        $value = intval($value);
        if ($value) {
            $query->where($column, '<=', $value);
        }
    }

    /**
     * Sort helper
     *
     * @param Builder $query
     * @param string $sortBy
     */
    protected function sort(Builder $query, $sortBy = '')
    {
        if (Listing::columnExists($sortBy)) {
            // Determine sort order by checking if the sort string begins with '-'
            $order = $sortBy[0] === '-' ? 'desc' : 'asc';
            // Remove the '-' from string
            $sortBy = $sortBy[0] === '-' ? substr($sortBy, 1) : $sortBy;

            $query->orderBy($sortBy, $order);
        }
    }
}
