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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::group(['domain' => 'art.local', 'middleware' => ['web', 'guest']], function () {

    Route::get('/', 'AppController@index');
    
});

Route::group(['domain' => 'seller.art.local', 'middleware' => ['web', 'guest']], function () {

    Route::get('/', 'AppController@seller');

    Route::group(['namespace' => 'Auth'], function () {
   
        Route::get('login','LoginController@showLogin')->name('login');
        Route::post('login','LoginController@doLogin')->name('doLogin');
        Route::get('signup','RegisterController@signup');
        Route::post('signup','RegisterController@register')->name('register');
        Route::get('verifyemail/{token}', 'RegisterController@verify');
    
    });
    //Authenticated Routes
    Route::group(['middleware' => ['auth'],'namespace' => 'Seller'], function () {
    
        Route::get('dashboard', 'DashboardController@index');
        Route::get('logout','DashboardController@logout')->name('logout');
    
    });
    
    
});




