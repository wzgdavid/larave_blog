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


}
