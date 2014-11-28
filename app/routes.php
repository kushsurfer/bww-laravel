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


Route::get('/', array('uses' => 'ShopController@shop', 'as' => 'shoppage'));
Route::get('/deviceDetail/{id}', array('uses' => 'ShopController@deviceDetail', 'as' => 'deviceDetail'));
Route::get('/planDetail/{id}', array('uses' => 'ShopController@planDetail', 'as' => 'planDetail'));
Route::get('/causeDetail/{id}', array('uses' => 'ShopController@causeDetail', 'as' => 'causeDetail'));

Route::get('/byosdhandset', array('uses' => 'ShopController@getBYOSDhansets', 'as' => 'byosdhandset'));
Route::get('/getDeviceList', array('uses' => 'ShopController@getDeviceList', 'as' => 'getDeviceList'));
Route::get('/getPlanOption', array('uses' => 'ShopController@getPlanOption', 'as' => 'getPlanOption'));


Route::get('/serviceplan', array('uses' => 'ShopController@serviceplan', 'as' => 'serviceplan'));
Route::get('/causes', array('uses' => 'ShopController@causes', 'as' => 'causes'));

Route::get('/testurl', array('uses' => 'ShopController@testurl', 'as' => 'testurl'));
Route::get('/shop', array('uses' => 'ShopController@index', 'as' => 'shop'));
Route::get('/orderSummary', array('uses' => 'ShopController@orderSummary', 'as' => 'orderSummary'));
Route::get('/checkout', array('uses' => 'ShopController@checkout', 'as' => 'checkout'));
Route::get('/facebooklogin', array('uses' => 'ShopController@facebooklogin', 'as' => 'facebooklogin'));

// check for hackers
// Route::group(array('before' => 'csrf'), function(){
	Route::post('/setOrderSet', array('uses' => 'ShopController@setOrderSet', 'as' => 'setOrderSet'));
	Route::post('/setAddress', array('uses' => 'SController@setAddress', 'as' => 'setAddress'));
	Route::post('/checkMEID', array('uses' => 'SController@checkMEID', 'as' => 'checkMEID'));
	Route::post('/shopAddtoCart', array('uses' => 'ShopController@addToCart', 'as' => 'shopAddtoCart'));
	Route::post('/createAccount', array('uses' => 'ShopController@createAccount', 'as' => 'createAccount'));
	Route::get('/getCurrentCartInfo', array('uses' => 'ShopController@getCurrentCartInfo', 'as' => 'getCurrentCartInfo'));
	Route::get('/addToCart', array('uses' => 'SController@addToCart', 'as' => 'addToCart'));
// });


Route::get('/demotest', array('uses' => 'SController@demo', 'as' => 'demo'));
Route::get('/checkdevice', array('uses' => 'SController@checkdevice', 'as' => 'checkdevice'));
Route::get('/testcon', array('uses' => 'SController@testconnection', 'as' => 'testcon'));

Route::get('facebook/authorize', function() {
    return OAuth::authorize('facebook');
});

use \AdamWathan\EloquentOAuth\ApplicationRejectedException;
use \AdamWathan\EloquentOAuth\InvalidAuthorizationCodeException;

Route::get('facebook/login', function() {
    try {
        OAuth::login('facebook');
    } catch (ApplicationRejectedException $e) {
        // User rejected application
    } catch (InvalidAuthorizationCodeException $e) {
        // Authorization was attempted with invalid
        // code,likely forgery attempt
    }

    // Current user is now available via Auth facade
    $user = Auth::user();

    return Redirect::intended();
});

