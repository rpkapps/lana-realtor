<?php

namespace App\Helpers;


class ListingHelper
{
    static function getBuyTypes()
    {
        $types = [
            'House' => 'House',
            'Land' => 'Land',
            'Multi-Family House' => 'Multi-Family',
            'Commercial' => 'Commercial',
            'Condo' => 'Condo',
            'Townhome' => 'Townhome',
            'Mobile Home' => 'Mobile',
            'Other' => 'Other'
        ];

        return $types;
    }

    static function getRentTypes()
    {
        $types = [
            'Apartment' => 'Apartment',
            'Single Family House' => 'Single Family',
            'Condo' => 'Condo',
            'Townhome' => 'Townhome',
            'Other' => 'Other'
        ];

        return $types;
    }

    static function determineSqFtPrice($Price, $SqFt)
    {
        return $Price / $SqFt;
    }
}