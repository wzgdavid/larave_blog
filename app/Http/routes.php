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

    // create new sitemap object
    $sitemap = App::make("sitemap");

    // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
    // by default cache is disabled
    $sitemap->setCache('laravel.sitemap', 100);

    // check if there is cached sitemap and build new only if is not
    //if (!$sitemap->isCached())
    {
         // add item to the sitemap (url, date, priority, freq)
         $sitemap->add(URL::to('/test'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
         //$sitemap->add(URL::to('page'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');

         // add item with translations (url, date, priority, freq, images, title, translations)
         $translations = [
                           ['language' => 'fr', 'url' => URL::to('pageFr')],
                           ['language' => 'de', 'url' => URL::to('pageDe')],
                           ['language' => 'bg', 'url' => URL::to('pageBg')],
                         ];
         $sitemap->add(URL::to('pageEn'), '2015-06-24T14:30:00+02:00', '0.9', 'monthly', [], null, $translations);

         // add item with images
         $images = [
                     ['url' => URL::to('images/pic1.jpg'), 'title' => 'Image title', 'caption' => 'Image caption', 'geo_location' => 'Plovdiv, Bulgaria'],
                     ['url' => URL::to('images/pic2.jpg'), 'title' => 'Image title2', 'caption' => 'Image caption2'],
                     ['url' => URL::to('images/pic3.jpg'), 'title' => 'Image title3'],
                   ];
         $sitemap->add(URL::to('post-with-images'), '2015-06-24T14:30:00+02:00', '0.9', 'monthly', $images);

         // get all posts from db
         $users = DB::table('users')->orderBy('created_at', 'desc')->get();

         // add every post to the sitemap
         foreach ($users as $user)
         {
            $sitemap->add($user->name, $user->email, $user->activated, $user->created_at);
         }
    }
    $sitemap->store('xml', 'sitemap');
    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    return $sitemap->render('xml');

});


Route::get('sitemap3', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");
    
    $sitemap->add(URL::to('page2'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');

    $sitemap->store('xml', 'mysitemap');
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


    });


});

