<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;


class ArticleController extends Controller
{
    //


    public function index(Request $request)
    {
        
        //$user = $request->user();
        return view('article.index', [
            'article' => Article::find(7899),
            //'user' => $user,
        ]);
    }
}
