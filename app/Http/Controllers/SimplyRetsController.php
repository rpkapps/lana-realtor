<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

// TODO: DELETE THIS CONTROLLER


class SimplyRetsController extends Controller
{
    private function appendTo($request, $key, &$array) 
    {
        if(is_array($request->input($key))) {
            foreach($request->input($key) as $value) {
                array_push($array, $key . '=' . $value);
            }
        }
        else if($request->input($key)) {
            array_push($array, $key . '=' . $request->input($key));
        }
    }

    public function getIndex(Request $request)
    {
        $filters = array();

        $this->appendTo($request, 'q', $filters);
        $this->appendTo($request, 'type', $filters);


        $client = new \GuzzleHttp\Client;

        $url = 'https://api.simplyrets.com/properties?'. implode('&', $filters);

        $listings = $client->get(
            $url,
            ['auth' => [env('SIMPLYRETS_USERNAME'), env('SIMPLYRETS_PASSWORD')]]
        );

        // Parse it into an array
        $listings = json_decode($listings->getBody(), true);


        return view('pages.listings', compact('listings'));

        return view('pages.listings');

    }
}
