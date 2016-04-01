<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Roumen\Sitemap\Sitemap;
//use Sentry, Redirect, App, Config, URL;
class SitemapController extends Controller
{

	protected $sitemap;

    
    public function __construct(Sitemap $sitemap)
    {
        
        
        $this->sitemap = $sitemap;
    }
    public function sitemap(Request $request)
    {
    // create new sitemap object
    $sitemap = App::make("sitemap");
    
    $sitemap->add(URL::to('page2'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');

    $sitemap->store('xml', 'mysitemap');
    return $sitemap->render('xml');
    }
}
