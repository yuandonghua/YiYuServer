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


/*
 * 有关token操作（指定到App\Http\Controllers\Auth）
 */
Route::group([], function () {
    Route::post('me', 'Auth\AuthController@me')->name('me');
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('logout', 'Auth\AuthController@logout')->name('logout');
    Route::post('refresh', 'Auth\AuthController@refresh')->name('refresh');
});


