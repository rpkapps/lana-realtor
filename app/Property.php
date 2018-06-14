<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Property extends Model
{
    const QUERYABLE_COLUMNS = [
        'area',
        'bathrooms',
        'bedrooms',
        'parkingDescription',
        'terms',
        'streetNumber',
        'streetName',
        'city',
        'postalCode',
        'elementarySchool',
        'middleSchool',
        'highSchool',
        'listPrice'
    ];
}
