<?php

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

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    Route::post('register', 'RegisterController@register')->name('api.v1.register');
    Route::post('login', 'LoginController@login')->name('api.v1.login')->middleware(['api']);
    Route::post('logout', 'LoginController@logout')->name('api.v1.logout')->middleware(['api']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['namespace' => 'ShortUrl', 'prefix' => 'short-url'], function () {
        Route::get('/', 'RedirectToShortUrlController')->name('api.v1.short-url.redirect');
        Route::post('/', 'CreateShortUrlController')->name('api.v1.short-url.create');
    });
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::get('token', 'GetTokenController')->name('api.v1.token.get');
        Route::post('logout', 'LoginController@logout')->name('api.v1.logout');
    });
});
