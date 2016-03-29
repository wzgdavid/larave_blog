<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Roumen\Sitemap\Sitemap;

class SitemapController extends Controller
{

	protected $sitemap;

    
    public function __construct(Sitemap $sitemap)
    {
        
        
        $this->sitemap = $sitemap;
    }
    public function sitemap(Request $request, Sitemap $sitemap)
    {
            // create new sitemap object
    	//$sitemap = Sitemap(config('sitemap'));


    	// add items to the sitemap (url, date, priority, freq)
    	$sitemap->add(URL::to('page2'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    	$sitemap->add(URL::to('page3'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
    	// get all posts from db

    	// add every post to the sitemap
    

    	// generate your sitemap (format, filename)
    	$sitemap->store('xml', 'mysitemap');
    	// this will generate file mysitemap.xml to your public folder
    	return $sitemap->render('xml');
    }
}
