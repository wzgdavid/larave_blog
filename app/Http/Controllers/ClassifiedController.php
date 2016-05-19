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
    	
    }
}
