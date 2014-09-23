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

Route::get('/', array('uses' => 'HomeController@hello', 'as' => 'home'));

// use if you are a guest user or not login
Route::group(array('before' => 'guest'), function(){

	Route::get('user/create', array('uses' => 'UserController@getCreate', 'as' => 'getCreate'));
	Route::get('user/login', 'UserController@getLogin');

	// check for hackers
	Route::group(array('before' => 'csrf'), function(){
		Route::post('/user/create', array('uses' => 'UserController@postCreate', 'as' => 'postCreate'));
		Route::post('/user/login', 'UserController@postLogin');
	});
});
