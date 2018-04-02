<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class SimplyRetsController extends Controller
{
    function getIndex()
    {
        $client = new \GuzzleHttp\Client;

        $listings = $client->get(
            'https://api.simplyrets.com/properties',
            ['auth' => [env('SIMPLYRETS_USERNAME'), env('SIMPLYRETS_PASSWORD')]]
        );

        // Parse it into an array
        $listings = json_decode($listings->getBody(), true);

        return view('pages.listings', compact('listings'));

    }
}
