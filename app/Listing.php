<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


/**
 * App\Listing
 *
 * @property int $id
 * @property int|null $mls_id
 * @property string|null $sub_type
 * @property string|null $area
 * @property int|null $system_price
 * @property int|null $asking_price
 * @property string|null $street_number
 * @property string|null $street_name
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $sale_rent
 * @property string|null $construction
 * @property string|null $foundation
 * @property string|null $age
 * @property string|null $garage
 * @property string|null $style
 * @property float|null $acres
 * @property string|null $listing_date
 * @property string|null $mls_updated_at
 * @property int|null $photo_count
 * @property string|null $photo_timestamp
 * @property string|null $full_address
 * @property string|null $status
 * @property float|null $price_per_sqft
 * @property string|null $elementary_school
 * @property string|null $middle_school
 * @property string|null $high_school
 * @property int|null $parking_spaces
 * @property int|null $beds
 * @property int|null $full_baths
 * @property int|null $partial_baths
 * @property int|null $garage_spaces
 * @property int|null $total_baths
 * @property int|null $year_built
 * @property int|null $residence_sqft
 * @property string|null $listing_description
 * @property string|null $additional_street_info
 * @property float|null $price_per_acre
 * @property string|null $lot_size
 * @property int|null $building_sqft
 * @property string|null $rent_date_available
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $photos
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $type
 * @property string|null $thumbnails
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing distance($lat, $lng, $distance = 30)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereAcres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereAdditionalStreetInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereAskingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereBeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereBuildingSqft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereConstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereElementarySchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereFoundation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereFullBaths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereGarage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereGarageSpaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereHighSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereListingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereListingDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereLotSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereMiddleSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereMlsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereMlsUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereParkingSpaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing wherePartialBaths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing wherePhotoCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing wherePhotoTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing wherePricePerAcre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing wherePricePerSqft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereRentDateAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereResidenceSqft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereSaleRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereStreetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereSystemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereThumbnails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereTotalBaths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereYearBuilt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Listing whereZipCode($value)
 * @mixin \Eloquent
 */
class Listing extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Scoped search
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            $search = str_replace(',', '', $search);
            $search = preg_replace('/\s+/', ' ', $search);

            $query->where(DB::raw('CONCAT_WS(" ", street_number, street_name, city, state, zip_code)'), 'LIKE',
                '%' . $search . '%');
            $query->orWhere('mls_id', 'LIKE', '%' . $search . '%');
        }
        return $query;
    }

    /**
     * Find listings that are within a certain distance of a lat/long point
     *
     * @param $query
     * @param $lat: latitude
     * @param $lng: longitude
     * @param $distance
     */
    public function scopeDistance($query, $lat, $lng, $distance = 30)
    {
        return $query
            ->select(DB::raw("*,
                     (3959 * acos(cos(radians($lat))
                           * cos(radians(latitude))
                           * cos(radians($lng) - radians(longitude))
                           + sin(radians($lat))
                           * sin(radians(latitude)))) AS distance")
            )->having('distance', '<', $distance);
    }

    /**
     * Returns true if $column exists in the Listing table
     *
     * @param $column
     * @return bool
     */
    static function columnExists($column)
    {
        return in_array($column, Schema::getColumnListing('listings'));
    }

    /**
     * This function ensures that the photos is an array
     *
     * @param $photos
     * @return array
     */
    static function arrayifyPhotos($photos)
    {
        try {
            if ($photos[0] === '[') {
                $photosArr = json_decode($photos);
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
