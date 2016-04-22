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
        Log::info('admin_list----------------------------');
        Log::info($request);
        Log::info('admin_list----------------------------');
        return view('article.admin_list', [
            'article' => Article::find(7899),
            //'user' => $user,
            "request" => $request,
        ]);
    }
}
