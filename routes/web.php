<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Route::get('admin/login', 'AdminController@login');
    Route::post('admin/login', 'AdminController@login');
    Route::group([
        'middleware' => 'auth.admin'
    ], function () {
        Route::get('index/index', 'IndexController@index');
        Route::get('index/home', 'IndexController@home');
        Route::get('index/test', 'IndexController@test');
        Route::get('index/test1', 'IndexController@test1');
        Route::get('index/test2', 'IndexController@test2');
    });
});
