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
            'FRM' => 'Farm For Sale'
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

}