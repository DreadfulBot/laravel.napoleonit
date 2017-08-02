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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'category', 'middleware' => ['auth:api']],function () {

    // todo: add passports for security check
    Route::get('/get', ['uses' => 'ApiCategory@get', 'as' => 'api.category.get']);

    Route::post('/post', ['uses' => 'ApiCategory@post', 'as' => 'api.category.post']);

    Route::put('/put', ['uses' => 'ApiCategory@put', 'as' => 'api.category.put']);

    Route::delete('/delete', ['uses' => 'ApiCategory@delete', 'as' => 'api.category.delete']);
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api']],function () {

    // todo: add passports for security check
    Route::get('/get', ['uses' => 'ApiUser@get', 'as' => 'api.user.get']);

    Route::post('/post', ['uses' => 'ApiUser@post', 'as' => 'api.user.post']);

    Route::put('/put', ['uses' => 'ApiUser@put', 'as' => 'api.user.put']);

    Route::delete('/delete', ['uses' => 'ApiUser@delete', 'as' => 'api.user.delete']);
});

