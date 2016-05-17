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

    //Route::get('sitemap', 'SitemapController@sitemap');
    Route::get('sitemap',['uses'=>'SitemapController@sitemap']);

});



Route::get('sitemap2', function(){
    //$path=$_SERVER["DOCUMENT_ROOT"].'/sitemap.xml';
    $path=public_path().'/sitemap.xml';
    $books=new DOMDocument();
    $books->load($path);
    $urlset=$books->getElementsByTagName('urlset')->item(0);

    $new_url=$books->createElement('url');
    $new_loc=$books->createElement('loc');
    $new_lastmod=$books->createElement('lastmod');
    $new_loc->nodeValue='new_loc nodeValue===================';
    $new_lastmod->nodeValue='new_lastmod ===================';
    $new_url->appendChild($new_loc);
    $new_url->appendChild($new_lastmod);
    $urlset->appendChild($new_url);
    //echo $urlset->item(1)->nodeValue;
    $books->save($path);
});


Route::get('sitemap3', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");
    
    $sitemap->add(URL::to('page2'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    $sitemap->add(URL::to('sitempaaaaappppp'), '', '0.9', 'monthly');
    $sitemap->add('localhost:7000', '', '0.9', 'monthly');
    /*$sitemap->add(URL::to('page2'));
    $sitemap->add(URL::to('sitempaaaaappppp'));
    $sitemap->add('localhost:7000');*/

    $sitemap->store('xml', 'sitemap');
    return $sitemap->render('xml');
});





Route::get('/article', 'ArticleController@index');
//Route::get('/admin/article/list', 'ArticleController@admin_list');



Route::group(['middleware' => ['web']], function ()
{
    Route::group(['middleware' => ['admin_logged', 'can_see']], function ()
    {
        Route::get('/admin/article/list', [
            'middleware' => 'has_perm:_superadmin,_group-editor',
            'uses' => 'ArticleController@admin_list',
            'as' => 'admin.article.list',
        ]);

        Route::get('/admin/article/edit', [
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

    });


});

