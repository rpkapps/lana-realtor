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

Route::get('/buy', ['as' => 'buy', 'uses' => 'PagesController@getBuyListings']);
Route::get('/rent', ['as' => 'rent', 'uses' => 'PagesController@getRentListings']);

Route::get('/listing/m/{mlsId}', ['as' => 'listing-mls', 'uses' => 'PagesController@getMlsListing']);

Route::get('/listing/l/{id}', ['as' => 'listing-local', 'uses' => 'PagesController@getLocalListing']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/', ['as' => 'voyager.dashboard', 'uses' => 'Voyager@redirectToProperties']);
});
