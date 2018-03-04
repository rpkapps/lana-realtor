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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PropertyResource::collection(Property::query()->paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return PropertyResource
     */
    public function show(Property $property)
    {
        return new PropertyResource($property);
    }
}
