@extends('layouts.classified')




@section('main_left')
<div class="main_left">

            <div class="panel-body">
                {!! Form::model($classified, [ 'url' => [URL::route('classified.submit_edit'), $classified->id], 'method' => 'post'] )  !!}
                       
                <!-- category -->
                <div class="form-group">
                    <font color="red">*</font>
                    {!! Form::label("category","select category") !!}
                    {!! Form::select('category_id', $category_array, 
                        (isset($classified->category_id) && $classified->category_id) ? $classified->category_id : "0",['class' => 'form-control'] ) !!}  
                </div>
                <span class="text-danger">{!! $errors->first('category_id') !!}</span>
                <!-- classified title field -->
                <div class="form-group">
                    <font color="red">*</font>
                    {!! Form::label('title','title: ') !!}
                    
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('title') !!}</span>
                <div class="form-group">
                    {!! Form::label("district","city area:") !!}
                    {!! Form::select('district_id', [
                                1=>'Xuhui',
                                2=>"Jing'an",
                                3=>'Huangpu',
                                4=>'Pudong',
                                5=>'Luwan',
                                6=>'Changning',
                                7=>'Putuo',
                                8=>'Other',
                                
                                ],
                        (isset($classified->district_id) && $classified->district_id) ? $classified->district_id : "0",['class' => 'form-control'] ) !!}
                            
                </div>
                <div class="form-group">
                    {!! Form::label("merto_line","metro line: ") !!}
                            {!! Form::select('merto_line', [
                                1=>'Line 1',
                                2=>'Line 2',
                                3=>'Line 3',
                                4=>'Line 4',
                                5=>'Line 5',
                                6=>'Line 6',
                                7=>'Line 7',
                                8=>'Line 8',
                                9=>'Line 9',
                                10=>'Line 10',
                                11=>'Line 11',
                                12=>'Line 12',
                                13=>'Line 13',
                                14=>'Line 14',
                                15=>'Line 15',
                                16=>'Line 16',
                                ], (isset($classified->merto_line) && $classified->merto_line) ? $classified->merto_line : "0",['class' => 'form-control'] ) !!}
                            
                
                </div>
                <div class="form-group">
                    {!! Form::label("station","station: ") !!}
                            {!! Form::select('station', [
                                
                                ], (isset($classified->station) && $classified->station) ? $classified->station : "0",['class' => 'form-control'] ) !!}
                            
                
                </div>
                <div class="form-group">
                    {!! Form::label('price','price:') !!}
                    {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                </div>
                <!-- content -->
                <div class="form-group">
                    <font color="red">*</font>
                    {!! Form::label('content','Description: ') !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('content') !!}</span>
                {!! Form::hidden('id') !!}
                
                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                {!! Form::close() !!}
              
            </div>
</div>
<script>
    $("#merto_line").change(function(){
        
        var line=$(this).val();
        //alert(line);
        $.get( "/classified/get_metro_stations", { line: line} )
            .done(function( data ) {
                var json_data = eval('(' + data + ')');
                //alert( "Data Loaded: " + json_data );
                /*for(var i=0; i<json_data.length; i++)  {
                    //alert(json_data[i])
                    $.each(json_data[i],function(name,value) {
                            alert(name);
                            //alert(value);
                    });
                }*/
                $( "#station option" ).remove();
                for(var obj in json_data){  
                    var id = json_data[obj].id;
                    var station = json_data[obj].station
                    var option = '<option value="'+id+'">'+station+'</option>'; 
                    $("#station").append(option);
                }

            });
        }); 
</script>
@endsection

