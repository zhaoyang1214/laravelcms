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
Route::group([
    'namespace' => 'Home'
], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/category/{urlname}', 'CategoryController@index');
    Route::get('/content/{urltitle}', 'ContentController@index');
    Route::get('/search', 'SearchController@index');
    Route::get('/tags/index', 'TagsController@index');
    Route::get('/tag/{tag}', 'TagsController@info');
    Route::get('/form/index/{no}', 'FormController@index');
    Route::post('/form/add', 'FormController@add');
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
        Route::get('categorymodel/index', 'CategorymodelController@index');
        Route::get('categorymodel/info/{id}', 'CategorymodelController@info')->where('id', '[1-9][0-9]*');
        Route::post('categorymodel/edit', 'CategorymodelController@edit');
        Route::get('admingroup/index', 'AdmingroupController@index');
        Route::match([
            'get',
            'post'
        ], 'admingroup/add', 'AdmingroupController@add');
        Route::get('admingroup/info/{id}', 'AdmingroupController@info')->where('id', '[1-9][0-9]*');
        Route::post('admingroup/edit', 'AdmingroupController@edit');
        Route::post('admingroup/delete', 'AdmingroupController@delete');
        Route::get('admin/index', 'AdminController@index');
        Route::match([
            'get',
            'post'
        ], 'admin/add', 'AdminController@add');
        Route::get('admin/info/{id}', 'AdminController@info')->where('id', '[1-9][0-9]*');
        Route::post('admin/edit', 'AdminController@edit');
        Route::post('admin/delete', 'AdminController@delete');
        Route::get('admin/editInfo/{id}', 'AdminController@editInfo')->where('id', '[1-9][0-9]*');
        Route::post('admin/editInfo', 'AdminController@editInfo');
        Route::get('adminlog/index', 'AdminlogController@index');
        Route::get('form/index', 'FormController@index');
        Route::match([
            'get',
            'post'
        ], 'form/add', 'FormController@add');
        Route::get('form/info/{id}', 'FormController@info')->where('id', '[1-9][0-9]*');
        Route::post('form/edit', 'FormController@edit');
        Route::post('form/delete', 'FormController@delete');
        Route::get('formfield/index/{formId}', 'FormfieldController@index')->where('formId', '[1-9][0-9]*');
        Route::get('formfield/add/{formId}', 'FormfieldController@add')->where('formId', '[1-9][0-9]*');
        Route::post('formfield/add', 'FormfieldController@add');
        Route::get('formfield/info/{id}', 'FormfieldController@info')->where('id', '[1-9][0-9]*');
        Route::post('formfield/edit', 'FormfieldController@edit');
        Route::post('formfield/delete', 'FormfieldController@delete');
        Route::get('formdata/index/{formId}', 'FormdataController@index')->where('formId', '[1-9][0-9]*');
        Route::get('formdata/add/{formId}', 'FormdataController@add')->where('formId', '[1-9][0-9]*');
        Route::post('formdata/add', 'FormdataController@add');
        Route::get('formdata/info/{formId}/{id}', 'FormdataController@info')->where([
            'formId' => '[1-9][0-9]*',
            'id' => '[1-9][0-9]*'
        ]);
        Route::post('formdata/edit', 'FormdataController@edit');
        Route::post('formdata/delete', 'FormdataController@delete');
        Route::get('expand/index', 'ExpandController@index');
        Route::match([
            'get',
            'post'
        ], 'expand/add', 'ExpandController@add');
        Route::get('expand/info/{id}', 'ExpandController@info')->where('id', '[1-9][0-9]*');
        Route::post('expand/edit', 'ExpandController@edit');
        Route::post('expand/delete', 'ExpandController@delete');
        Route::get('expandfield/index/{expandId}', 'ExpandfieldController@index')->where('expandId', '[1-9][0-9]*');
        Route::get('expandfield/add/{expandId}', 'ExpandfieldController@add')->where('expandId', '[1-9][0-9]*');
        Route::post('expandfield/add', 'ExpandfieldController@add');
        Route::get('expandfield/info/{id}', 'ExpandfieldController@info')->where('id', '[1-9][0-9]*');
        Route::post('expandfield/edit', 'ExpandfieldController@edit');
        Route::post('expandfield/delete', 'ExpandfieldController@delete');
        Route::get('fragment/index', 'FragmentController@index');
        Route::match([
            'get',
            'post'
        ], 'fragment/add', 'FragmentController@add');
        Route::get('fragment/info/{id}', 'FragmentController@info')->where('id', '[1-9][0-9]*');
        Route::post('fragment/edit', 'FragmentController@edit');
        Route::post('fragment/delete', 'FragmentController@delete');
        Route::get('replace/index', 'ReplaceController@index');
        Route::match([
            'get',
            'post'
        ], 'replace/add', 'ReplaceController@add');
        Route::get('replace/info/{id}', 'ReplaceController@info')->where('id', '[1-9][0-9]*');
        Route::post('replace/edit', 'ReplaceController@edit');
        Route::post('replace/delete', 'ReplaceController@delete');
        Route::get('tags/index', 'TagsController@index');
        Route::post('tags/grouping', 'TagsController@grouping');
        Route::post('tags/delete', 'TagsController@delete');
        Route::get('tagsgroup/index', 'TagsgroupController@index');
        Route::match([
            'get',
            'post'
        ], 'tagsgroup/add', 'TagsgroupController@add');
        Route::get('tagsgroup/info/{id}', 'TagsgroupController@info')->where('id', '[1-9][0-9]*');
        Route::post('tagsgroup/edit', 'TagsgroupController@edit');
        Route::post('tagsgroup/delete', 'TagsgroupController@delete');
        Route::get('position/index', 'PositionController@index');
        Route::match([
            'get',
            'post'
        ], 'position/add', 'PositionController@add');
        Route::get('position/info/{id}', 'PositionController@info')->where('id', '[1-9][0-9]*');
        Route::post('position/edit', 'PositionController@edit');
        Route::post('position/delete', 'PositionController@delete');
        Route::get('upload/index', 'UploadController@index');
        Route::post('upload/delete', 'UploadController@delete');
        Route::get('category/index', 'CategoryController@index');
        Route::post('category/sequence', 'CategoryController@sequence');
        Route::match([
            'get',
            'post'
        ], 'categorynews/add', 'CategorynewsController@add');
        Route::get('categorynews/info/{id}', 'CategorynewsController@info')->where('id', '[1-9][0-9]*');
        Route::post('categorynews/edit', 'CategorynewsController@edit');
        Route::post('categorynews/delete', 'CategorynewsController@delete');
        Route::match([
            'get',
            'post'
        ], 'categorypage/add', 'CategorypageController@add');
        Route::get('categorypage/info/{id}', 'CategorypageController@info')->where('id', '[1-9][0-9]*');
        Route::post('categorypage/edit', 'CategorypageController@edit');
        Route::post('categorypage/delete', 'CategorypageController@delete');
        Route::match([
            'get',
            'post'
        ], 'categoryjump/add', 'CategoryjumpController@add');
        Route::get('categoryjump/info/{id}', 'CategoryjumpController@info')->where('id', '[1-9][0-9]*');
        Route::post('categoryjump/edit', 'CategoryjumpController@edit');
        Route::post('categoryjump/delete', 'CategoryjumpController@delete');
        Route::get('content/list', 'ContentController@list');
        Route::get('content/manage', 'ContentController@manage');
        Route::get('content/index/{categoryId}', 'ContentController@index')->where('categoryId', '[1-9][0-9]*');
        Route::post('content/audit', 'ContentController@audit');
        Route::get('content/add/{categoryId}', 'ContentController@add')->where('categoryId', '[1-9][0-9]*');
        Route::post('content/add', 'ContentController@add');
        Route::get('content/info/{id}', 'ContentController@info')->where('id', '[1-9][0-9]*');
        Route::post('content/edit', 'ContentController@edit');
        Route::post('content/delete', 'ContentController@delete');
        Route::get('content/quickEdit/{id}', 'ContentController@quickEdit')->where('id', '[1-9][0-9]*');
        Route::post('content/quickEdit', 'ContentController@quickEdit');
        Route::post('content/move', 'ContentController@move');
        Route::post('content/getKeywords', 'ContentController@getKeywords');
    });
});
