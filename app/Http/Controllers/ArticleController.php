<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use View, Redirect, App, Config, Log;

class ArticleController extends Controller
{
    //
    protected $auth;

    public function index(Request $request)
    {
        
        //$user = $request->user();
        return view('article.index', [
            'article' => Article::find(7899),
            //'user' => $user,
        ]);
    }

    public function admin_list(Request $request)
    {
        /*Log::info('admin_list----------------------------');
        Log::info($request);
        Log::info('admin_list----------------------------');*/


        //$articles = Article::all();
        // too many data ,so for easy (for temp
        $articles = Article::take(20)->get(); 
        /*$articles = Article::orderBy('author_id', 'desc')
               ->take(50)
               ->get();*/
        return view('article.admin_list', [
            'articles' => $articles,
            //'user' => $user,
            "request" => $request,
        ]);
    }
}
