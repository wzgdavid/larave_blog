<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use App\ArticleAuthor;
use App\ArticleCategory;
use App\ArticleType;
use View, Redirect, App, Config, Log, DB, Event,Storage;
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
            'article_category' => ArticleCategory::find(1),
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
        /*try{
            
        }
        catch(UserNotFoundException $e){
            $article = new Article;
        }*/
        $category_array = array('no category');
        
            /*$categories = ArticleCategory::all();
            $types = ArticleType::all();*/

        $categories = DB::table('article_category as a')
            ->leftJoin('article_type as t', 'a.main_category_id', '=', 't.id')
            ->leftJoin('article_category as b', 'a.parent_id', '=', 'b.id')
            ->select('a.*', 'b.name as parent_name', 't.name as type_name')
            ->orderBy('a.sort', 'asc')
            ->get();
            //Log::info('-----------------------------------');
        foreach ($categories as $c){

                //Log::info($c->type_name.' - '.$c->parent_name.' - '.$c->name);
                $key = $c->id;
                $value = $c->type_name.' - '.$c->parent_name.' - '.$c->name;
                $category_array[$key] = $value;
        }



        $id = $request->get('id');
        if (isset( $id )){
            $article = Article::find($request->get('id'));
            $author = ArticleAuthor::find($article->author_id);
            if (isset($author)){
                $author_name = $author->author_name;
            }else{
                $author_name = 'no author';
            }
            $user = User::find($article->user_id);
            if (isset($user)){
                $user_name = $user->name;
            }else{
                $user_name = 'no user';
            }   

            //Log::info('-----------------------------------');

            //$photo_src = 'http://localhost:8000/'.$article->pic;
            $photo_src = config('app.host_url').$article->pic;

            return view('article.admin_article_edit', [
                'article' => $article,
                "request" => $request,
                'author_name' => $author_name,
                'user_name' => $user_name,
            /*'category_array' =>[0=>'no category',
                                1=>'aaa',
                                2=>'bbb']*/
                'category_array' =>$category_array,
                'photo_src' =>$photo_src,
            ]);
        }
        else
        {
            $article = new Article;
            $article->save();
            $article->datetime_publish = date("Y-m-d").' '.date("h:i:s");
            $article->datetime_unpublish = date("Y-m-d").' '.date("h:i:s");
            $article->tags='tags';
            return view('article.admin_article_edit', [
                'article' => $article,
                "request" => $request,
                'author_name' => '',
                'user_name' => '',
                'category_array' =>$category_array,
                'photo_src' => '',
            ]);
        }




    }

    public function post_edit_article(Request $request)
    {
        $id = $request->get('id');

        $article = Article::find($id);
        $tags = $request->get('tags');
        $article->retag($tags);
        //Event::fire('repository.updating', [$article]);
        $data = $request->all();
        $publish_date = $request->get('publish_date');
        $publish_time = $request->get('publish_time');
        $unpublish_date = $request->get('unpublish_date');
        $unpublish_time = $request->get('unpublish_time');


        $data['datetime_publish'] = $publish_date.' '.$publish_time;
        $data['datetime_unpublish'] = $unpublish_date.' '.$unpublish_time;
        /*Log::info('---------------------------------77');
        Log::info($data);
        Log::info('---------------------------------77');*/
        //unset($data['_token']);
        $article->update($data);
        //return $article;
        return Redirect::route('admin.article.edit',["id" => $article->id])->withMessage(Config::get('acl_messages.flash.success.article_edit_success'));
    }


    public function changepic(Request $request){
        $file = $request->file('file');
        $id = $request->get('article_id');
        /*Log::info('---------------------------------111');
        Log::info($id);
        Log::info('---------------------------------111');*/
        $article = Article::find($id);

        if($file -> isValid()){
            $originalName = $file -> getClientOriginalName();
            $extension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            //echo $extension.'</br>';
            $newName = md5(date('ymdhis').$originalName).".".$extension;

            $path = $file -> move(public_path().'/article/image/',$newName);
            $pic = 'article/image/'.$newName;
            
            @unlink ($article->pic); //delete the origin pic
            $article->update([
                'pic' => $pic,
            ]);

        }

        return Redirect::route('admin.article.edit',["id" => $article->id])->withMessage(Config::get('acl_messages.flash.success.article_upload_pic_success'));
    }



}
