<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Voyager extends Controller
{
    /**
     * Redirect to properties index
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirectToListings() {
        return redirect(route('voyager.listings.index'));
    }
}
