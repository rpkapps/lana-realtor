<?php

namespace App\Http\Controllers;

use App\Property;
use GuzzleHttp\Client;

class PagesController extends Controller
{

	public function getIndex() {
		return view('pages.home');
	}

	public function getContact() {
		return view('pages.contact');
	}

	public function getBuyListings() {
	    $title = 'For Sale';
	    $showNavCheckboxes = true;

		return view('pages.listings', compact('title', 'showNavCheckboxes'));
	}

    public function getRentListings() {
        $title = 'For Rent';
        $showNavCheckboxes = false;

        return view('pages.listings', compact('title', 'showNavCheckboxes'));
    }

	public function getMlsListing($mlsId) {
        $url = 'https://api.simplyrets.com/properties/'. $mlsId;
        $showNavCheckboxes = false;

        try {
            $listing = (new Client)->get(
                $url,
                ['auth' => [env('SIMPLYRETS_USERNAME'), env('SIMPLYRETS_PASSWORD')]]
            );

            // Parse it into an array
            $listing = json_decode($listing->getBody(), true);
        } catch (\Exception $e) {
            abort(404);
        }

		return view('pages.mls-listing-item', compact('listing', 'showNavCheckboxes'));
	}

	public function getLocalListing($id) {
        $listing = Property::find($id);
        $showNavCheckboxes = false;

        $listing['photos'] = Property::arrayifyPhotos( $listing['photos']);

        if (!$listing){
            abort(404);
        }

        return view('pages.local-listing-item', compact('listing', 'showNavCheckboxes' ));
    }
}