@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit classified
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- model general errors from the form --}}
        @if($errors->has('model') )
        <div class="alert alert-danger">{{$errors->first('model')}}</div>
        @endif

        {{-- successful message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{{$message}}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title bariol-thin">{!! isset($classified->id) ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-lock"></i> Create' !!} classified</h3>
            </div>
            <div class="panel-body">
                
        
                {!! Form::model($classified, [ 'url' => [URL::route('admin.classified.edit'), $classified->id], 'method' => 'post'] )  !!}
                       
                

                <!-- classified title field -->
                <div class="form-group">
                    {!! Form::label('title','title: *') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('title') !!}</span>


                <!-- content -->
                <div class="form-group">
                    {!! Form::label('content','content: ') !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                </div>





                {!! Form::hidden('id') !!}
                <a href="{!! URL::route('admin.classified.delete',['id' => $classified->id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">Delete</a>
                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_scripts')
{!! HTML::script('packages/jacopo/laravel-authentication-acl/js/vendor/slugit.js') !!}
<script>
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
    $(function(){
        $('#slugme').slugIt();
    });
</script>
@stop