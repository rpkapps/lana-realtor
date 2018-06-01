<?php

namespace App\Helpers;


class SimplyRetsHelper
{
    static function determineTitle($type)
    {
        $types = [
            'RES' => 'HOUSE FOR SALE',
            'RNT' => 'HOUSE FOR RENT',
            'MLF' => 'HOUSE FOR SALE',
            'CRE' => 'COMMERCIAL BUILDING FOR SALE',
            'LND' => 'LAND FOR SALE',
            'FRM' => 'FARM FOR SALE'
        ];

        return $types[$type] ? $types[$type] : 'Invalid Listing';
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