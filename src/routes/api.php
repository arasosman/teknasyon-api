<?php

use Illuminate\Http\Request;

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

Route::post('register', 'AuthController@register')->name('api.register');
Route::post('login', 'AuthController@login')->name('api.login');

Route::get('test', function () {
    return "Hello Word";
});

Route::middleware('auth:api')->group(function () {
    Route::get('logout', 'AuthController@logout')->name('api.logout');
    Route::get('user', 'AuthController@user')->name('api.user');
});



