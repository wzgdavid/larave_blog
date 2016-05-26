@extends('layouts.classified')




@section('main_left')
<div class="main_left">
            <div class="panel-body">
                {!! Form::model($classified, [ 'url' => [URL::route('classified.submit_edit'), $classified->id], 'method' => 'post'] )  !!}
                       
                <!-- category -->
                <div class="form-group">
                    {!! Form::label("category","select category") !!}
                    {!! Form::select('category_id', $category_array, 
                        (isset($classified->category_id) && $classified->category_id) ? $classified->category_id : "0",['class' => 'form-control'] ) !!}  
                </div>
                <!-- classified title field -->
                <div class="form-group">
                    {!! Form::label('title','title: *') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
                </div>

                {!! Form::hidden('id') !!}
                
                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                {!! Form::close() !!}
              
            </div>
</div>

@endsection

