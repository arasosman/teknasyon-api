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

Route::get('test', function () {
    return "Hello Word";
});

Route::group([], function () {
    Route::post('register', 'AuthController@register')->name('api.register');
    Route::post('login', 'AuthController@login')->name('api.login');

});

Route::prefix('config')->group(function () {
    Route::get('/', 'ConfigController@get');
    Route::post('/check', 'ConfigController@check');
});

Route::middleware('check.token')->group(function () {
    Route::get('logout', 'AuthController@logout')->name('api.logout');
    Route::get('user', 'AuthController@user')->name('api.user');
});
