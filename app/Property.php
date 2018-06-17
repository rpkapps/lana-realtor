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
}
