<?php

namespace App\Helpers;


class FormHelper
{
    static function checked($key, $value) {
        return is_array(request()->input($key)) && in_array($value, request()->input($key)) ? 'checked' : '';
    }

    static function value($key) {
        return request()->input($key) ? request()->input($key) : '';
    }

    static function activeClass($key, $value){
		return request()->input($key) == $value ? 'active' : '';
    }    	
}