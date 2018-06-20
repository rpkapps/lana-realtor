<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Voyager extends Controller
{
    /**
     * Redirect to properties index
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirectToProperties() {
        return redirect(route('voyager.properties.index'));
    }
}
