<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Listing extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    const QUERYABLE_COLUMNS = [
        'street_number',
        'street_name',
        'city',
        'zip_code',
    ];

    /**
     * This function ensures that the photos is an array
     * @param $photos
     * @return array
     */
    static function arrayifyPhotos($photos)
    {
        try {
            if ($photos[0] === '[') {
                // $photos is an array in string format
                $photos = preg_replace('/[\[\]]/g', '', $photos);
                $photosArr = explode(',', $photos);
            } else {
                // $photos is a single photo in string format
                $photosArr = [$photos];
            }
        } catch (\Exception $e) {
            $photosArr = [];
        }

        return $photosArr;
    }    
}
