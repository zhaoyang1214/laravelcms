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
    Route::match([
        'get',
        'post'
    ], 'admin/login', 'AdminController@login');
    Route::middleware([
        'auth.admin'
    ])->group(function () {
        Route::get('index/index', 'IndexController@index');
        Route::get('index/home', 'IndexController@home');
        Route::post('index/cleanCache', 'IndexController@cleanCache');
        Route::get('admin/loginOut', 'AdminController@loginOut');
        Route::get('systemset/index', 'SystemsetController@index');
        Route::post('systemset/save', 'SystemsetController@save');
        Route::match([
            'get',
            'post'
        ], 'ueditor/index', 'UeditorController@index');
        Route::post('ueditor/index', 'UeditorController@index');
        Route::get('ueditor/getUpfileHtml', 'UeditorController@getUpfileHtml');
    });
});
