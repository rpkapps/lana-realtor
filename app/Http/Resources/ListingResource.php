<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ListingResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $listing = parent::toArray($request);

        $listing['photos'] = json_decode($listing['photos']);
        $listing['thumbnails'] = json_decode($listing['thumbnails']);

        return $listing;
    }
}
