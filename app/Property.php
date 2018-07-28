<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Property
 *
 * @property int $id
 * @property int|null $area
 * @property int|null $bathrooms
 * @property int|null $bedrooms
 * @property string|null $parkingDescription
 * @property string|null $terms
 * @property int|null $streetNumber
 * @property string|null $streetName
 * @property string|null $city
 * @property int|null $postalCode
 * @property string|null $elementarySchool
 * @property string|null $middleSchool
 * @property string|null $highSchool
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $photos
 * @property int|null $listPrice
 * @property string|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereElementarySchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereHighSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereListPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereMiddleSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereParkingDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereStreetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
