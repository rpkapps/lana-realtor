<?php

namespace App\Http\Resources;

use App\Listing;
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
                'type',
                'sale_rent',
                'asking_price',
                'street_number',
                'full_address',
                'city',
                'state',
                'zip_code',
                'beds',
                'total_baths',
                'residence_sqft',
                'acres',
                'photos'
            ]
        );


        $photos = Listing::decodePhotos($listing['photos']);

        // Only get the first photo and thumbnail we don't need all of them for
        // the minimal listing
        $listing['photos'] = count($photos) ? [$photos[0]] : [];

        return $listing;
    }
}
