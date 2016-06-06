<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ClassifiedPostRequest;
use App\Classified;
use App\ClassifiedCategory;
use View, Redirect, App, Config, Log, DB, Event,Storage, Menu;
use Illuminate\Validation\Validator;

class ClassifiedController extends Controller
{
    public function __construct($config_reader = null)
    {
        $this->config_reader = $config_reader ? $config_reader : App::make('config');
        $this->results_per_page = $this->config_reader->get('acl_base.rows_per_page');
        $this->authenticator = App::make('authenticator');
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
        
        
        //$classifieds = $q->take($this->results_per_page)->get();
        $classifieds = $q->paginate($this->results_per_page);
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
        else
        {
            $classified = new Classified;
            //$classified->save();
            $classified->start_datetime = date("Y-m-d").' '.date("h:i:s");
            $classified->end_datetime = date("Y-m-d",strtotime("+100 year")).' '.date("h:i:s");

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

    public function list_view(Request $request, $cate1 = null, $cate2=null){
        // in SHexpat
        //qs = qs.filter(is_approved=True).order_by('-create_datetime')
        Menu::make('MyNavBar', function($menu){

            $menu->add('Electronics',   Url('/classified/electronics'));
            $menu->add('Furniture',    Url('/classified/furniture'));
            $menu->add('Vehicles',     Url('/classified/vehicles'));
            $menu->add('Pets',    Url('/classified/pets'));
            $menu->add('Clothing & Jewelry',    Url('/classified/cothing-jewelry'))
                ->nickname('clothing');
            $menu->add('Musical Instruments',    Url('/classified/musical-instruments'))
                ->nickname('instruments');
            //$menu->item('instruments')->add('Other Vehicles', array('route'  => 'classified.item_view'));
            $menu->add('Sporting Goods',    Url('/classified/sporting-goods'));
            $menu->add('Other',    Url('/classified/other'));
            $menu->item('electronics')->add('Cell phones',Url('/classified/electronics/cell-phones'));
            $menu->item('electronics')->add('Computers', Url('/classified/electronics/computers'));
            $menu->item('electronics')->add('Cameras', Url('/classified/electronics/cameras'));
            $menu->item('electronics')->add('TV', Url('/classified/electronics/tv'));
            $menu->item('furniture')->add('Equipment', Url('/classified/furniture/equipment'));
            $menu->item('furniture')->add('Home Furnishing', Url('/classified/furniture/home-furnishing'));
            $menu->item('vehicles')->add('Bikes', Url('/classified/vehicles/bikes'));
            $menu->item('vehicles')->add('Scooters', Url('/classified/vehicles/scooters'));
            $menu->item('vehicles')->add('Cars', Url('/classified/vehicles/cars'));
            $menu->item('vehicles')->add('Other Vehicles', Url('/classified/vehicles/other-vehicles'));

        });

        $classifieds = Classified::where('is_approved', 1)
            ->orderBy('create_datetime', 'desc')
            ->paginate(20);
        return view('classified.list_view', [
                "request" => $request,
                'classifieds' => $classifieds,

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
            $item = Classified::find($id);
           

            return view('classified.item_view', [
                'item' => $item,
                "request" => $request,
                //'category_array' =>$category_array,
            ]);
        }else{
            echo 'page not found';
        }
    }

    public function edit_view(Request $request){
        $classified = new Classified;
        $categories = ClassifiedCategory::all();
        $category_array = array('--------');
        foreach ($categories as $c){
                $key = $c->id;
                $value = $c->name;
                $category_array[$key] = $value;
        }
        return view('classified.edit_view',[
            'classified' => $classified,
            "request" => $request,
            'category_array' =>$category_array,
        ]);
    }

    public function submit_edit(Request $request){
        $category_id = $request->get('category_id');
        //$classified = Classified::find($id);


        $this->validate($request, [
            'title' => 'required|max:200',
            'content' => 'required|max:60000',
            //'category_id' => 'required|digits_between:1,9999999',
            'category_id' => 'required|not_in:0',

            
        ]);
        //$validator = Validator::make($input, $rules, $messages);
        $classified = new Classified;
        $classified->is_approved = 1;
        $data = $request->all();

        $logged_user = $this->authenticator->getLoggedUser();
        $user_id = $logged_user->user_profile()->first()->id;
        $classified->contributor_id = $user_id;
        $classified->title = $data['title'];
        $classified->save();
        $classified->update($data);


        return redirect('/classified');
       
    }
    public function get_metro_stations(Request $request){
        $line = $request->get('line');
        $stations = DB::table('metro')
                ->select('id', 'station')
                ->where('line', $line)
                ->get();
        return  json_encode($stations);

    }
}
