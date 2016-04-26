<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use App\ArticleAuthor;
use View, Redirect, App, Config, Log, DB, Event;
use Cartalyst\Sentry\Users\Eloquent\User;

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
        //$articles = Article::orderBy('page_title', 'desc')
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
            $article = Article::find($request->get('id'));
        }
        catch(UserNotFoundException $e)
        {
            $article = new Article;
        }

        try
        {

            $author = ArticleAuthor::find($article->author_id);
            if (isset($author)){
                $author_name = $author->author_name;
            }else{
                $author_name = 'no author';
            }
           
        }
        catch(UserNotFoundException $e)
        {
            $author_name = 'no author';
        }

        try
        {

            $user = User::find($article->user_id);
            if (isset($user)){
                $user_name = $user->name;
            }else{
                $user_name = 'no user';
            }
           
        }
        catch(UserNotFoundException $e)
        {
            $user_name = 'no this user';
        }
        
        return view('article.admin_article_edit', [
            'article' => $article,
            "request" => $request,
            'author_name' => $author_name,
            'user_name' => $user_name,
        ]);

    }

    public function post_edit_article(Request $request)
    {
        $id = $request->get('id');

        $article = Article::find($id);
        $tags = $request->get('tags');
        $article->retag($tags);
        //Event::fire('repository.updating', [$article]);
        $data = $request->all();
        //unset($data['_token']);
        $article->update($data);
        //return $article;
        return Redirect::route('admin.article.edit',["id" => $article->id])->withMessage(Config::get('acl_messages.flash.success.article_edit_success'));
    }

}
