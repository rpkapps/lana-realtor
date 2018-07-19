<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ListingResource;

class ListingController extends Controller
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

        $query = Listing::query();

        // Pagination limit per page
        $limit = $request->query('limit', 9);

        // Search query
        $this->search($query, Listing::QUERYABLE_COLUMNS, $request->query('q'));

        // Min Price
        $this->minFilter($query, 'system_price', $request->get('minprice'));

        // Max Price
        $this->maxFilter($query, 'system_price', $request->get('maxprice'));

        // Min Area
        $this->minFilter($query, 'area', $request->get('minarea'));

        // Max Area
        $this->maxFilter($query, 'area', $request->get('maxarea'));

        // Min Bedrooms
        $this->minFilter($query, 'beds', $request->get('minbeds'));

        // Max Bedrooms
        $this->maxFilter($query, 'beds', $request->get('maxbeds'));

        // Min Bathrooms
        $this->minFilter($query, 'total_baths', $request->get('minbaths'));

        // Min Bathrooms
        $this->maxFilter($query, 'total_baths', $request->get('maxbaths'));

        // Sort
        $this->sort($query, $request->get('sort'), $columnMap);

        return ListingResource::collection($query->paginate($limit));
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
     * Search filter helper
     *
     * @param Builder $query
     * @param array $columns
     * @param $value
     */
    protected function search(Builder $query, $columns = [], $value)
    {
        // TODO: Fix search for full addresses
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

        if (array_key_exists($sortBy, $columnMap)) {
            $query->orderBy($columnMap[$sortBy], $order);
        }

    }

}
