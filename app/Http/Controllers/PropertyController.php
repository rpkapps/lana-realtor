<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Property;
use Illuminate\Database\Eloquent\Builder;
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
        $columnMap = [
            'listprice' => 'listPrice',
            'listdate' => 'created_at',
            'beds' => 'bedrooms',
            'baths' => 'bathrooms'
        ];

        $query = Property::query();

        // Pagination limit per page
        $limit = $request->query('limit', 9);

        // Search query
        $this->search($query, Property::QUERYABLE_COLUMNS, $request->query('q'));

        // Min Price
        $this->minFilter($query, 'listPrice', $request->get('minprice'));

        // Max Price
        $this->maxFilter($query, 'listPrice', $request->get('maxprice'));

        // Min Area
        $this->minFilter($query, 'area', $request->get('minarea'));

        // Max Area
        $this->maxFilter($query, 'area', $request->get('maxarea'));

        // Min Bedrooms
        $this->minFilter($query, 'bedrooms', $request->get('minbeds'));

        // Max Bedrooms
        $this->maxFilter($query, 'bedrooms', $request->get('maxbeds'));

        // Min Bathrooms
        $this->minFilter($query, 'bathrooms', $request->get('minbaths'));

        // Min Bathrooms
        $this->maxFilter($query, 'bathrooms', $request->get('maxbaths'));

        // Sort
        $this->sort($query, $request->get('sort'), $columnMap);

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

    /**
     * Search filter helper
     *
     * @param Builder $query
     * @param array $columns
     * @param $value
     */
    protected function search(Builder $query, $columns = [], $value)
    {
        if ($value) {
            foreach ($columns as $index => $column) {
                $query->orWhere($column, 'LIKE', '%' . $value . '%');
            }
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
     * @param array $columnMap
     */
    protected function sort(Builder $query, $sortBy = '', $columnMap = [])
    {
        // Determine sort order by checking if the sort string begins with '-'
        $order = $sortBy[0] === '-' ? 'desc' : 'asc';
        // Remove the '-' from string
        $sortBy = $sortBy[0] === '-' ? substr($sortBy, 1) : $sortBy;

        if ($columnMap[$sortBy]) {
            $query->orderBy($columnMap[$sortBy], $order);
        }

    }

}
