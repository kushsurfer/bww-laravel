<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('hello');
// });

Route::get('/', array('uses' => 'ShopController@shop', 'as' => 'shoppage'));
Route::get('/deviceDetail/{id}', array('uses' => 'ShopController@deviceDetail', 'as' => 'deviceDetail'));
Route::get('/planDetail/{id}', array('uses' => 'ShopController@planDetail', 'as' => 'planDetail'));

// Route::get('/selectdevice/{id}/{price}', array('uses' => 'ShopController@selectdevice', 'as' => 'selectdevice'));
// Route::get('/selectplan/{id}/{price}', array('uses' => 'ShopController@selectplan', 'as' => 'selectplan'));
// Route::get('/selectcause/{id}/{price}', array('uses' => 'ShopController@selectcause', 'as' => 'selectcause'));


Route::get('/serviceplan', array('uses' => 'ShopController@serviceplan', 'as' => 'serviceplan'));
Route::get('/causes', array('uses' => 'ShopController@causes', 'as' => 'causes'));

Route::get('/testurl', array('uses' => 'ShopController@testurl', 'as' => 'testurl'));
Route::get('/shop', array('uses' => 'ShopController@index', 'as' => 'shop'));

// check for hackers
// Route::group(array('before' => 'csrf'), function(){
	Route::post('/setOrderSet', array('uses' => 'ShopController@setOrderSet', 'as' => 'setOrderSet'));
// });


// Route::group(array('prefix' => '/forum'), function(){
// 	Route::get('/', array('uses' => 'ForumController@index', 'as' => 'forum-home'));
// 	Route::get('/category/{id}', array('uses' => 'ForumController@category', 'as' => 'forum-category'));
// 	Route::get('/thread/{id}', array('uses' => 'ForumController@thread', 'as' => 'forum-thread'));
// });

// // use if you are a guest user or not login
// Route::group(array('before' => 'guest'), function(){

// 	Route::get('user/create', array('uses' => 'UserController@getCreate', 'as' => 'getCreate'));
// 	Route::get('user/login', array('uses' => 'UserController@getLogin', 'as' => 'getLogin'));



// Route::group(array('before' => 'auth'), function(){
// 	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));

// });