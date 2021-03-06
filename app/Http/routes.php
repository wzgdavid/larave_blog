<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/test', function () {

        Storage::disk('local')->put('file.txt', 'Contents');
    });

});



Route::group(['middleware' => ['web']], function ()
{


    Route::get('/articles', [
        'as'   => 'article.list_view',
        'uses' => 'ArticleController@list_view',
    ]);
    Route::get('/articles/item_view', [
        'as'   => 'article.item_view',
        'uses' => 'ArticleController@item_view',
    ]);
    Route::get('/articles/item/{hyperlink}', [
        'as'   => 'article.item_view2',
        'uses' => 'ArticleController@item_view2',
    ]);
    Route::get('/classified/item_view', [
        'as'   => 'classified.item_view',
        'uses' => 'ClassifiedController@item_view',
    ]);
    Route::get('/classified/get_metro_stations', [
        'as'   => 'classified.get_metro_stations',
        'uses' => 'ClassifiedController@get_metro_stations',
    ]);

    //need user logged
    Route::group(['middleware' => ['logged']], function ()
    {
        Route::get('/classified/edit_view', [
            'as'   => 'classified.edit_view',
            'uses' => 'ClassifiedController@edit_view',
        ]);
        Route::post('/classified/edit_view', [
            'as'   => 'classified.submit_edit',
            'uses' => 'ClassifiedController@submit_edit',
        ]);

    });
    
    Route::get('/classified/{cate1?}/{cate2?}', [
        'as'   => 'classified',
        'uses' => 'ClassifiedController@list_view',
    ]);

    //need admin logged
    Route::group(['middleware' => ['admin_logged', 'can_see']], function ()
    {
        Route::get('/admin/article/list', [
            'middleware' => 'has_perm:_superadmin,_group-editor',
            'uses' => 'ArticleController@admin_list',
            'as' => 'admin.article.list',
        ]);
        Route::get('/admin/article/edit', [
            'middleware' => 'has_perm:_superadmin,_group-editor',
                'as'   => 'admin.article.edit',
                'uses' => 'ArticleController@edit_article',
        ]);
        Route::post('/admin/article/edit', [
                'as'   => 'admin.article.edit',
                'uses' => 'ArticleController@post_edit_article'
        ]);
        Route::get('/admin/article/delete', [
                'as'   => 'admin.article.delete',
                'uses' => 'ArticleController@delete_article'
        ]);
        Route::post('/admin/article/changepic', [
                'as'   => 'admin.article.changepic',
                'uses' => 'ArticleController@changepic'
        ]);
        Route::get('/admin/article/searchtags', [
                'as'   => 'admin.article.searchtags',
                'uses' => 'ArticleController@searchtags'
        ]);

        Route::get('/admin/classified/list', [
            'middleware' => 'has_perm:_superadmin,_group-editor',
            'uses' => 'ClassifiedController@admin_list',
            'as' => 'admin.classified.list',
        ]);
        Route::get('/admin/classified/edit', [
                'as'   => 'admin.classified.edit',
                'uses' => 'ClassifiedController@edit',
        ]);
        Route::post('/admin/classified/edit', [
                'as'   => 'admin.classified.edit',
                'uses' => 'ClassifiedController@post_edit'
        ]);
        Route::get('/admin/classified/delete', [
                'as'   => 'admin.classified.delete',
                'uses' => 'ClassifiedController@delete'
        ]);
    });


});

