<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'PagesController@getIndex']);

Route::get('/contact', ['as' => 'contact', 'uses' => 'PagesController@getContact']);

Route::get('/listings', ['as' => 'listings', 'uses' => 'PagesController@getListings']);

Route::get('/listing-item/{mlsId}', ['as' => 'listing-item', 'uses' => 'PagesController@getListingItem']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
