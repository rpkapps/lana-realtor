<?php

namespace App\Http\Controllers;

use App\MLS\GFBRConnector;
use App\Listing;
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
	    $pageType = 'buy';

		return view('pages.listings', compact('title', 'pageType'));
	}

    public function getRentListings() {
        $title = 'For Rent';
        $pageType = 'rent';

        return view('pages.listings', compact('title', 'pageType'));
    }


	public function getListing($id) {
        $listing = Listing::find($id);

        $pageType = 'rent';

        if (!$listing){
            abort(404);
        }

        $listing['photos'] = Listing::decodePhotos($listing['photos']);
        $listing['thumbnails'] = Listing::decodePhotos($listing['thumbnails']);

        
        return view('pages.listing-item', compact('listing', 'pageType' ));
    }
}