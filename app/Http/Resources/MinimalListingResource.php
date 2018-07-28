<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MinimalListingResource extends Resource
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
                'mls_id',
                'photos',
                'sale_rent',
                'sale_rent',
                'asking_price',
                'full_address',
                'city',
                'state',
                'zip_code',
                'beds',
                'total_baths',
                'residence_sqft',
                'residence_sqft',
                'acres',
                'photos',
                'thumbnails'
            ]
        );

        $listing['photos'] = json_decode($listing['photos']);
        $listing['thumbnails'] = json_decode($listing['thumbnails']);

        return $listing;
    }
}
