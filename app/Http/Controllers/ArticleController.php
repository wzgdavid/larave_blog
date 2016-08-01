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
use DOMDocument;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    //
    protected $auth;
    
    public function __construct($config_reader = null,ArticleRepository $articles)
    {
        //$this->article_repository = App::make('article_repository');
        $this->config_reader = $config_reader ? $config_reader : App::make('config');
        $this->results_per_page = $this->config_reader->get('acl_base.rows_per_page');
        $this->authenticator = App::make('authenticator');
        $this->articles = $articles;

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

    public function admin_list_backup(Request $request)
    {
        
        $articles = Article::orderBy('date_created', 'desc')
        //$articles = Article::orderBy('page_title', 'desc')
               ->take($this->results_per_page)
               ->get();

        return view('article.admin_article_list', [
            'articles' => $articles,
            //'user' => $user,
            "request" => $request,
        ]);
    }

    public function admin_list(Request $request)
    {
        //Log::info('admin_list-----------------99999--------');
        //Log::info($request);

        $q = Article::orderBy('date_created', 'desc');
        $filter = $request->except(['page']);
        foreach($filter as $key => $value){
            if($value !== ''){
                switch($key){
                    case 'title':
                        $q = $q->where('title', 'like', '%'.$value.'%');
                        break;
                    case 'is_home_featured':
                        $q = $q->where('is_home_featured', $value);
                        break;
                    case 'is_homepage_sponsored':
                        $q = $q->where('is_homepage_sponsored', $value);
                        break;
                    case 'is_shf_featured':
                        $q = $q->where('is_shf_featured', $value);
                        break;
                    case 'is_shf_sponsored':
                        $q = $q->where('is_shf_sponsored', $value);
                        break;
                }
            }
        }
        
        
        //$q = $q->select('*');
        $articles = $q->paginate($this->results_per_page);
        return view('article.admin_article_list', [
            'articles' =>  $articles,
            //'user' => $user,
            "request" => $request,
        ]);
    }

    public function delete_article(Request $request){
        //Article::destroy($request->get('id')); // alse can use ->input('id')
        $aid = $request->get('id');
        $this->articles->delete($aid);
        $this->remove_from_sitemap($aid);
        return redirect('/admin/article/list');
    }

    public function edit_article(Request $request)
    {
        /*try{
            
        }
        catch(UserNotFoundException $e){
            $article = new Article;
        }*/
        $category_array = array('--------');
        
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


        $article_id = $request->get('id');
        if (isset( $article_id )){
            $article = Article::find($article_id);
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
            //$article->save();
            //$article->retag('');
            $article->datetime_publish = date("Y-m-d").' '.date("h:i:s");
            //$article->datetime_unpublish = date("Y-m-d",strtotime("+100 year")).' '.date("h:i:s");
            //$article->datetime_unpublish = '';
            

            $logged_user = $this->authenticator->getLoggedUser();
            $user_id = $logged_user->user_profile()->first()->id;
            $user = User::find($user_id);
            if (isset($user)){
                $user_name = $user->name;
            }else{
                $user_name = 'no user';
            }   
            $article->user_id = $user_id;
            $article->save();
            return view('article.admin_article_edit', [
                'article' => $article,
                //"request" => $request,
                'author_name' => '',
                'user_name' => $user_name,
                'category_array' =>$category_array,
                'photo_src' => '',
                
            ]);
        }

    }

    public function post_edit_article(Request $request)
    {
        $id = $request->get('id');

        $article = Article::find($id);
        if(!isset($article)){
            $article = new Article;
            $article->save();
        }
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
        //Log::info('------------is_in_sitemap---------------------77');
        //Log::info('article title ---'.$article->title);
        if ($request->get('is_in_sitemap') == 1) {
        
            //Log::info('is in sitemap');
            $this->add_to_sitemap($article->id, $article->hyperlink);
        }else{
            //Log::info($request->get('is_in_sitemap'));
            $this->remove_from_sitemap($id);
        }
        $this->check_unpublish();
        $article->update($data);
        //return $article;
        return Redirect::route('admin.article.edit',["id" => $article->id])->withMessage(Config::get('acl_messages.flash.success.article_edit_success'));
    }

    private function add_to_sitemap($article_id=null, $article_url=null, $lastmod=null){
        $path = public_path().'/sitemap.xml';
        $books = new DOMDocument();
        $books->load($path);

        $url_elements = $books->getElementsByTagName('url');
        foreach($url_elements as $one){
            if ($article_id == $one->getAttribute('article_id')) {
                return;
            }
        }

        $urlset = $books->getElementsByTagName('urlset')->item(0);
        $new_url = $books->createElement('url');
        $new_url->setAttribute('article_id', $article_id);
        $new_loc = $books->createElement('loc');
        $new_loc->nodeValue = $article_url;
        $new_lastmod = $books->createElement('lastmod');
        $changefreq = $books->createElement('changefreq');
        $changefreq->nodeValue = 'monthly';
        $new_lastmod->nodeValue = $lastmod;
        $new_url->appendChild($new_loc);
        $new_url->appendChild($new_lastmod);
        $new_url->appendChild($changefreq);
        $urlset->appendChild($new_url);
        //echo $urlset->item(1)->nodeValue;
        $books->save($path);
    }

    private function remove_from_sitemap($article_id=null){  
        $path = public_path().'/sitemap.xml';
        $books = new DOMDocument();
        $books->load($path);
        $url_elements = $books->getElementsByTagName('url');
        foreach($url_elements as $one){
            if ($article_id == $one->getAttribute('article_id')) {
                $one->parentNode->removeChild($one);
                $books->save($path);
                return;
            }
        }
        
    }

    private function check_unpublish(Request $request=null){
        /*if unpublish date, remove article from sitemap and change aproved to false
        */
        //Log::info('------------check_unpublish---------------------');
        $articles = Article::where('is_in_sitemap', 1)
               ->orderBy('datetime_unpublish', 'asc')
               ->take(10) //no need to check all
               ->get();
        $now = date("Y-m-d").' '.date("h:i:s");
        foreach($articles as $one){
            //Log::info($one->title);
            //Log::info(strtotime($now));
            //Log::info( strtotime($one->datetime_unpublish) );
            if ( strtotime($now) > strtotime($one->datetime_unpublish) ){

                $data = array();
                $data['is_in_sitemap'] = 0;
                $data['is_approved'] = 0;
                $one->update($data);
                //Log::info($one->id);
                $this->remove_from_sitemap($one->id);
            }
        }
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

    public function searchtags(Request $request){
        
        $term = $request->get('term');

        $availableTags = [];
        $tags = DB::table('tagging_tags')
                ->select('name')
                ->where('name', 'like', $term.'%')
                ->get();
    
        foreach ($tags as $tag){
            /*Log::info('-----------------searchtags----------------foreach');
            Log::info($tag->name);*/
            $availableTags[]=$tag->name;
        }

        return $availableTags;
    }

    public function list_view(Request $request){


        $articles = $this->articles->get_articles(); 


        return view('article.list_view', [
                "request" => $request,
                'articles' => $articles,

        ]);
    }

    public function item_view(Request $request){
        $id = $request->get('id');

        /*$categories = ClassifiedCategory::all();
        $category_array = array('--------');
        foreach ($categories as $c){

                //Log::info($c->type_name.' - '.$c->parent_name.' - '.$c->name);
                $key = $c->id;
                $value = $c->name;
                $category_array[$key] = $value;
        }*/
        if (isset( $id )){
            $item = Article::find($id);
           

            return view('article.item_view', [
                'item' => $item,
                "request" => $request,
                //'category_array' =>$category_array,
            ]);
        }else{
            echo 'page not found';
        }
    }

}
