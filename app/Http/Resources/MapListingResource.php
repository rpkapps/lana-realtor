<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MapListingResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $listing = array_only(
            parent::toArray($request),
            [
                'id',
                'asking_price',
                'full_address',
                'city',
                'state',
                'zip_code',
                'beds',
                'total_baths',
                'residence_sqft',
                'acres',
                'thumbnails',
                'latitude',
                'longitude'
            ]
        );


        $thumbnails = json_decode($listing['thumbnails']);

        // Only get the first photo and thumbnail we don't need all of them for
        // the minimal listing
        $listing['thumbnails'] = count($thumbnails) ? [$thumbnails[0]] : [];

        return $listing;
    }
}
