<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use View, Redirect, App, Config, Log, DB, Event;


class ArticleController extends Controller
{
    //
    protected $auth;
    public function __construct($config_reader = null)
    {
        //$this->article_repository = App::make('article_repository');
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

        return view('article.admin_article_list', [
            'articles' => $articles,
            //'user' => $user,
            "request" => $request,
        ]);
    }

    public function delete_article(Request $request){
        Article::destroy($request->get('id')); // alse can use ->input('id')
        return redirect('/admin/article/list');
    }

    public function edit_article(Request $request)
    {
        try
        {
            $obj = Article::find($request->get('id'));
        }
        catch(UserNotFoundException $e)
        {
            $obj = new Article;
        }

        //return View::make('laravel-authentication-acl::admin.group.edit')->with(["article" => $obj/*, "presenter" => $presenter*/]);
        return view('article.admin_article_edit', [
            'article' => $obj,
            "request" => $request,
        ]);

    }

    public function post_edit_article(Request $request)
    {
        $id = $request->get('id');

        $obj = Article::find($id);
        //Event::fire('repository.updating', [$obj]);
        $data = $request->all();
        //unset($data['_token']);
        $obj->update($data);
        //return $obj;
        return Redirect::route('admin.article.edit',["id" => $obj->id])->withMessage(Config::get('acl_messages.flash.success.article_edit_success'));
    }

}
