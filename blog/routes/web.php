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

Route::group(['middleware' => 'web'], function () {

    Auth::routes();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    // admin options
    Route::group(['prefix' => 'admin'], function () {

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
    });

    // categories
    Route::group(['prefix' => 'category'], function () {

        Route::get('{categoryId}/view', [
            'as' => 'category.view.id',
            'middleware' => ['can:category.view', 'auth'],
            'uses' => 'CategoryController@showCategory'
        ])->where('categoryId', '[0-9]+');

        Route::get('view', [
            'as' => 'category.view',
            'middleware' => ['can:category.list', 'auth'],
            'uses' => 'CategoryController@showCategories'
        ])->where('categoryId', '[0-9]+');


    });

    // articles
    Route::group(['prefix' => 'article'], function() {
        Route::get('/{articleId}/view', [
            'as' => 'article.view',
            'uses' => 'ArticleController@viewArticle',
            'middleware' => ['can:article.view', 'auth']
        ])->where('articleId', '[0-9]+');

        Route::get('/create/view', [
            'as' => 'article.create.view',
            'uses' => 'ArticleController@viewCreate',
            'middleware' => ['can:article.create', 'auth']
        ]);

        Route::post('/create', [
            'as' => 'article.create.submit',
            'uses' => 'ArticleController@submitCreate',
            'middleware' => ['can:article.create', 'auth']
        ]);

        Route::get('/update/{articleId}/view', [
            'as' => 'article.update.view',
            'uses' => 'ArticleController@viewUpdate',
            'middleware' => ['can:article.update', 'auth']
        ]);

        Route::post('/update', [
            'as' => 'article.update.submit',
            'uses' => 'ArticleController@submitUpdate',
            'middleware' => ['can:article.update', 'auth']
        ]);
    });

});
