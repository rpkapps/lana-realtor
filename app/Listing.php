<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


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
        if($search) {
            $search = str_replace(',', '', $search);
            $search = preg_replace('/\s+/', ' ', $search);

            $query->where(DB::raw('CONCAT_WS(" ", street_number, street_name, city, state, zip_code)'), 'LIKE',
                '%' . $search . '%');
            $query->orWhere('mls_id', 'LIKE', '%' . $search . '%');
        }
        return $query;
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
