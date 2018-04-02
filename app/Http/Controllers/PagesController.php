<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class PagesController extends Controller {

	public function getIndex()
	{
		$client = new \GuzzleHttp\Client;

		$listings = $client->get(
			'https://api.simplyrets.com/properties', 
			['auth' => ['simplyrets', 'simplyrets']]
		);

		// Parse it into an array
		$listsing = json_decode($listings->getBody(), true);

		var_dump($listings);

		return view('pages.home', $listings);
	}

	public function getContact()
	{
		return view('pages.contact');
	}
}