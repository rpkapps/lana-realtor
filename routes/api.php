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
    Route::get('listings', ['as' => 'listing.index', 'uses' => 'ListingController@index']);
    Route::get('listings/{listing}', ['as' => 'listing.show', 'uses' => 'ListingController@show']);
    Route::get('properties', ['as' => 'property.index', 'uses' => 'PropertyController@index']);
    Route::get('properties/{property}', ['as' => 'property.show', 'uses' => 'PropertyController@show']);
});

