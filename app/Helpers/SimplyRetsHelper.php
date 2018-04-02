<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 4/2/2018
 * Time: 4:53 PM
 */

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
}