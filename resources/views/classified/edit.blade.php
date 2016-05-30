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
                       
                <div class="form-group">
                            {!! Form::select('is_approved', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($classified->is_approved) && $classified->is_approved) ? $classified->is_approved : "0" ) !!}
                            {!! Form::label("is_approved","is approved ") !!}
                </div>                
                <div class="form-group">
                            {!! Form::select('is_individual', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($classified->is_individual) && $classified->is_individual) ? $classified->is_individual : "0" ) !!}
                            {!! Form::label("is_individual","is individual ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('featured', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($classified->featured) && $classified->featured) ? $classified->featured : "0" ) !!}
                            {!! Form::label("featured","is featured ") !!}
                </div>
                <!-- classified title field -->
                <div class="form-group">
                    {!! Form::label('title','title: *') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('slug','slug: ') !!}
                    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'slug']) !!}
                </div>

                <div class="form-group">

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
                                ], (isset($classified->merto_line) && $classified->merto_line) ? $classified->merto_line : "0" ) !!}
                            {!! Form::label("merto_line","merto line: ") !!}
                </div>

                <div class="form-group">
                    {!! Form::label('station','station:') !!}
                    {!! Form::text('station', null, ['class' => 'form-control', 'placeholder' => 'station']) !!}
                </div>
                <!-- content -->
                <div class="form-group">
                    {!! Form::label('content','content: ') !!}
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                </div>
                <!-- category -->
                <div class="form-group">
                    {!! Form::label("category","category") !!}
                    {!! Form::select('category_id', $category_array, 
                        (isset($classified->category_id) && $classified->category_id) ? $classified->category_id : "0",['class' => 'form-control'] ) !!}
                            
                </div>
                <div class="form-group">
                    {!! Form::label('contributor','Contributor: ') !!}
                    {!! Form::text('contributor_id', null, []) !!}
                </div>

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
                <!--start and end datetime-->
                <div class="form-group">
                    {!! Form::label('start_datetime','start_datetime: ') !!}
                    {!! Form::date('start_date', 
                        (isset($classified->start_datetime) && $classified->start_datetime) ?
                        explode(" ",$classified->start_datetime)[0] : '') !!}
                    {!! Form::time('start_time',                         
                        (isset($classified->start_datetime) && $classified->start_datetime) ?
                        explode(" ",$classified->start_datetime)[1] : '') !!}
                <!--start and end datetime-->
                <div class="form-group">  
                    {!! Form::label('end_datetime','end_datetime: ') !!}
                    {!! Form::date('end_date', 
                        (isset($classified->end_datetime) && $classified->end_datetime) ?
                        explode(" ",$classified->end_datetime)[0] : '') !!}
                    {!! Form::time('end_time', 
                        (isset($classified->end_datetime) && $classified->end_datetime) ?
                        explode(" ",$classified->end_datetime)[1] : '') !!}
                </div>
                <!-- classified price field -->
                <div class="form-group">
                    {!! Form::label('price','price: ') !!}
                    {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'price']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('forum_url','Forum Buy & Sell URL: ') !!}
                    {!! Form::text('forum_url', null, ['class' => 'form-control', 'placeholder' => 'forum_url']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label("size","size:") !!}
                    {!! Form::select('size', [
                                1=>'Studio',
                                2=>"1 Bedroom",
                                3=>'2 Bedrooms',
                                4=>'More than 2 Bedrooms',
                                ],
                        (isset($classified->size) && $classified->size) ? $classified->size : "0",['class' => 'form-control'] ) !!}
                            
                </div>
                <div class="form-group">
                    {!! Form::select('is_shared', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($classified->is_shared) && $classified->is_shared) ? $classified->is_shared : "0" ) !!}
                    {!! Form::label("is_shared","is shared: ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('is_agency', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($classified->is_agency) && $classified->is_agency) ? $classified->is_agency : "0" ) !!}
                            {!! Form::label("is_agency","is agency: ") !!}
                </div>
                <div class="form-group">
                    {!! Form::label('geo_location','geo location: ') !!}
                    {!! Form::text('geo_location', null, ['class' => 'form-control', 'placeholder' => 'geo_location']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('size_square','Size square: ') !!}
                    {!! Form::text('size_square', null, ['class' => 'form-control', 'placeholder' => 'size_square']) !!}
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