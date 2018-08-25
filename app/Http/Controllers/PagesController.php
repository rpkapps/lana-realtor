<?php

namespace App\Http\Controllers;

use App\MLS\GFBRConnector;
use App\Listing;
use GuzzleHttp\Client;
use SEOMeta;
use OpenGraph;
use Twitter;


class PagesController extends Controller
{
	public function getIndex() {
        SEOMeta::setTitle('Home');

		return view('pages.home');
	}

	public function getContact() {
		return view('pages.contact');
	}

	public function getBuyListings() {
	    $title = 'For Sale';
        $pageType = 'buy';
        
        // SEO
        SEOMeta::setTitle('Listings For Sale');

		return view('pages.listings', compact('title', 'pageType'));
	}

    public function getRentListings() {
        $title = 'For Rent';
        $pageType = 'rent';

        // SEO
        SEOMeta::setTitle('Listings For Rent');
        
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

        // SEO
        $title = $listing['sale_rent'] . ': ' . $listing['full_address'] . ', ' . $listing['city'] . ', ' . $listing['state'] . ', ' . $listing['zip_code'];

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($listing['listing_description']);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($listing['listing_description']);
        if(array_key_exists(0, $listing['photos'])) {
            OpenGraph::addImage($listing['photos'][0]);
        }

        Twitter::setTitle($title);
        Twitter::setDescription($listing['listing_description']);
        if(array_key_exists(0, $listing['photos'])) {
            Twitter::setImage($listing['photos'][0]);
        }

        return view('pages.listing-item', compact('listing', 'pageType' ));
    }
}