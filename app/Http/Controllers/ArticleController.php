<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use View, Redirect, App, Config, Log, DB;


class ArticleController extends Controller
{
    //
    protected $auth;
    public function __construct($config_reader = null)
    {
        $this->config_reader = $config_reader ? $config_reader : App::make('config');
    }

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
        $results_per_page = $this->config_reader->get('acl_base.rows_per_page');
        $articles = Article::orderBy('date_created', 'desc')
               ->take($results_per_page)
               ->get();

        return view('article.admin_list', [
            'articles' => $articles,
            //'user' => $user,
            "request" => $request,
        ]);
    }

    public function delete_article(Request $request){
        Article::destroy($request->input('id'));
        return redirect('/admin/article/list');
    }
}
