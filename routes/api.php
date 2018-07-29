<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    Route::get('listings/buy', ['as' => 'listings.buy.index', 'uses' => 'ListingController@buyIndex']);
    Route::get('listings/rent', ['as' => 'listings.rent.index', 'uses' => 'ListingController@rentIndex']);
    Route::get('listings/buy/map', ['as' => 'listings.buy.map', 'uses' => 'ListingController@buyMap']);
    Route::get('listings/rent/map', ['as' => 'listings.rent.map', 'uses' => 'ListingController@rentMap']);
    Route::get('listings/featured', ['as' => 'listings.featured.index', 'uses' => 'ListingController@featuredIndex']);
    Route::get('listings/{listing}', ['as' => 'listings.show', 'uses' => 'ListingController@show']);
});

