<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{

	public function getIndex() {
		return view('pages.home');
	}

	public function getContact() {
		return view('pages.contact');
	}

	public function getListings() {
		return view('pages.listings');
	}

	public function getListingItem($mlsId) {


        $client = new \GuzzleHttp\Client;

        $url = 'https://api.simplyrets.com/properties/'. $mlsId;

        $listing = $client->get(
            $url,
            ['auth' => [env('SIMPLYRETS_USERNAME'), env('SIMPLYRETS_PASSWORD')]]
        );

        // Parse it into an array
        $listing = json_decode($listing->getBody(), true);


		return view('pages.listing-item', compact('listing'));
	}
}