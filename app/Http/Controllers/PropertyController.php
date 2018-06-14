<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Property::query();

        // Pagination limit per page
        $limit = $request->query('limit', 9);
        // Search query
        $q = $request->query('q', null);

        // Search
        if($q) {
            foreach (Property::QUERYABLE_COLUMNS as $index => $column) {
                $query->orWhere($column, 'LIKE', '%' . $q . '%');
            }
        }

        // TODO: filter

        // TODO: sort

        return PropertyResource::collection($query->paginate($limit));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property $property
     * @return PropertyResource
     */
    public function show(Property $property)
    {
        return new PropertyResource($property);
    }
}
