<?php

namespace App\Helpers;


class SimplyRetsHelper
{
    static function determineTitle($type)
    {
        $types = [
            'RES' => 'House For Sale',
            'RNT' => 'House For Rent',
            'MLF' => 'House For Sale',
            'CRE' => 'Commercial Building For Sale',
            'LND' => 'Land For Sale',
            'FRM' => 'Farm For Sale',
            'CND' => 'Condo For Sale'
        ];

        try {
            return $types[$type];
        }
        catch (\Exception $e) {
            return 'Invalid Listing';
        }
    }

    static function getSubType()
    {
        $types = [
            'apartment' => 'Apartment', 
            'boatslip' => 'Boat',
            'singlefamilyresidence' => 'Single Family Residence',
            'deededparking' => 'Deeded Parking',
            'cabin' => 'Cabin',
            'condominium'  => 'Condominium',
            'duplex' => 'Duplex',
            'manufacturedhome' => 'Mobile Home',
            'ownyourown' => 'Own Your Own',
            'quadruplex' => 'Quadruplex',
            'stockcooperative' => 'Stock Cooperative',
            'townhouse' => 'Townhouse', 
            'timeshare' => 'Timeshare',
            'triplex' => 'Triplex',
            'manufacturedonland' => 'Manufacted On Land'
        ];

        return $types;
    }

    static function determineSqFtPrice($Price, $SqFt)
    {
        return $Price/$SqFt;
    }

}