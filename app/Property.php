<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Property extends Model
{
    const QUERYABLE_COLUMNS = [
        'streetNumber',
        'streetName',
        'city',
        'postalCode',
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
