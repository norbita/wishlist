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

Route::get('/', function () {
    return view('welcome');
});

Route::get('search/{id}/destroy', [
	'uses' 	=> 'SearchController@destroy',
	'as'	=> 'search.destroy'
]);

Route::get('search/add', [
	'uses' 	=> 'SearchController@add',
	'as'	=> 'search.add']);

	Route::get('search/list', [
		'uses' 	=> 'SearchController@list',
		'as'	=> 'search.list']);	

Route::get('sendemail',[ 
	'as' => 'sendemail.index', 
	'uses' => 'SendEmailController@index']);

Route::post('/sendemail/send', 'SendEmailController@send');

Route::get('sync',[ 
	'as' => 'sync.index', 
	'uses' => 'SyncWishlistController@index']);

Route::post('/sync/sync', 'SyncWishlistController@sync');

Route::get('wishlist/index', [ 
	'as' => 'wishlist.index', 
	'uses' => 'WishlistController@index']);

Route::get('wishlist/create', [ 
	'as' => 'wishlist.create', 
	'uses' => 'WishlistController@create']);

Route::post('wishlist',[ 
	'as' => 'wishlist.store', 
	'uses' => 'WishlistController@store']);

Route::get('wishlist/share', [ 
	'as' => 'wishlist.share', 
	'uses' => 'WishlistController@share']);	

Route::post('wishlist/send',[ 
	'as' => 'wishlist.send', 
	'uses' => 'WishlistController@send']);	

Route::get('wishlist/{id}/destroy', [
		'uses' 	=> 'WishlistController@destroy',
		'as'	=> 'wishlist.destroy']);

Route::resource('search','SearchController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
