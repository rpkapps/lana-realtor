<?php

namespace App\Http\Resources;

use App\Listing;
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

        $listing['photos'] = Listing::decodePhotos($listing['photos']);
        $listing['thumbnails'] = Listing::decodePhotos($listing['thumbnails']);

        return $listing;
    }
}
