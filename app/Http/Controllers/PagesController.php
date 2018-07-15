<?php

namespace App\Http\Controllers;

use App\MLS\GFBRConnector;
use App\Property;
use GuzzleHttp\Client;

class PagesController extends Controller
{

	public function getIndex() {
	    $mlsConnector = new GFBRConnector([
	       'loginUrl' => env('MLS_GFBR_LOGIN_URL'),
           'username' => env('MLS_GFBR_USERNAME'),
           'password' => env('MLS_GFBR_PASSWORD')
        ]);

	    dd($mlsConnector->pullAndSync());

	    // TODO: Remove above code in this function
		return view('pages.home');
	}

	public function getContact() {
		return view('pages.contact');
	}

	public function getBuyListings() {
	    $title = 'For Sale';
	    $pageType = 'buy';

		return view('pages.listings', compact('title', 'pageType'));
	}

    public function getRentListings() {
        $title = 'For Rent';
        $pageType = 'rent';

        return view('pages.listings', compact('title', 'pageType'));
    }

	public function getMlsListing($mlsId) {
        $url = 'https://api.simplyrets.com/properties/'. $mlsId;
        $pageType = 'buy';

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

		return view('pages.mls-listing-item', compact('listing', 'pageType'));
	}

	public function getLocalListing($id) {
        $listing = Property::find($id);
        $pageType = 'rent';

        $listing['photos'] = Property::arrayifyPhotos( $listing['photos']);

        if (!$listing){
            abort(404);
        }

        return view('pages.local-listing-item', compact('listing', 'pageType' ));
    }
}