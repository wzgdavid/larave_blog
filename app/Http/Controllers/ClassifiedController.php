<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classified;
use App\ClassifiedCategory;
use View, Redirect, App, Config, Log, DB, Event,Storage;


class ClassifiedController extends Controller
{
    public function __construct($config_reader = null)
    {
        $this->config_reader = $config_reader ? $config_reader : App::make('config');
        $this->results_per_page = $this->config_reader->get('acl_base.rows_per_page');
    }

    public function admin_list(Request $request){
        /*$classifieds = Classified::orderBy('create_datetime', 'desc')
               ->take($this->results_per_page)
               ->get();
        return view('classified.admin_list', [
            'classifieds' =>  $classifieds,
            //'user' => $user,
            "request" => $request,
        ]);*/

        $q = Classified::orderBy('create_datetime', 'desc');
        $filter = $request->except(['page']);
        foreach($filter as $key => $value){
            if($value !== ''){
                switch($key){
                    case 'title':
                        $q = $q->where('title', 'like', '%'.$value.'%');
                        break;
                }
            }
        }
        
        
        //$q = $q->select('*');
        $classifieds = $q->take($this->results_per_page)->get();
        return view('classified.admin_list', [
            'classifieds' =>  $classifieds,
            //'user' => $user,
            "request" => $request,
        ]);
    }

    public function delete(Request $request){
        Classified::destroy($request->get('id')); // alse can use ->input('id')
        return redirect('/admin/classified/list');
    }

    public function edit(Request $request){

    	$id = $request->get('id');
        /*Log::info('-------------edit--------------------77');
        Log::info($id);
        Log::info('-------------edit--------------------77');*/

        $categories = ClassifiedCategory::all();
        $category_array = array('--------');
        foreach ($categories as $c){

                //Log::info($c->type_name.' - '.$c->parent_name.' - '.$c->name);
                $key = $c->id;
                $value = $c->name;
                $category_array[$key] = $value;
        }
        if (isset( $id )){
            $classified = Classified::find($id);
           

            return view('classified.edit', [
                'classified' => $classified,
                "request" => $request,
                'category_array' =>$category_array,
            ]);
        }
    }

    public function post_edit(Request $request){
        $id = $request->get('id');

        $classified = Classified::find($id);

        $data = $request->all();
        //unset($data['_token']);
        $start_date = $request->get('start_date');
        $start_time = $request->get('start_time');
        $end_date = $request->get('end_date');
        $end_time = $request->get('end_time');
        $data['start_datetime'] = $start_date.' '.$start_time;
        $data['end_datetime'] = $end_date.' '.$end_time;
        $classified->update($data);
        //return $article;
        return Redirect::route('admin.classified.edit',["id" => $classified->id])->withMessage(Config::get('acl_messages.flash.success.classified_edit_success'));

    }

    public function list_view(Request $request){
        // in SHexpat
        //qs = qs.filter(is_approved=True).order_by('-create_datetime')
        $classifieds = Classified::paginate(20);
        return view('classified.list_view', [
                "request" => $request,
                'classifieds' => $classifieds,

        ]);
    }
}
