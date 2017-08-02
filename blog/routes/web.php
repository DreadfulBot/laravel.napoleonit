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

Route::group(['middleware'=>'web'], function () {

    Auth::routes();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'admin'], function() {

        Route::get('/category/list', [
            'uses' => 'CategoryController@listCategories',
            'as' => 'category.list',
            'middleware' => ['can:category.list', 'auth']
        ]);

        Route::get('/user/list', [
            'as' => 'user.list',
            'uses' => 'UserController@listUsers',
            'middleware' => ['can:user.list', 'auth']
        ]);

        Route::get('/article/list', [
            'as' => 'article.list',
            'middleware' => ['can:article.list', 'auth']
        ]);

        Route::post('/article/submit', [
            'as' => 'article.submit',
//            'uses' =>
            'middleware' => ['can:article.create', 'auth']
        ]);
    });

});
