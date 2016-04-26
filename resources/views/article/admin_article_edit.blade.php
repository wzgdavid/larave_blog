@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit article
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
                <h3 class="panel-title bariol-thin">{!! isset($article->id) ? '<i class="fa fa-pencil"></i> Edit' : '<i class="fa fa-lock"></i> Create' !!} article</h3>
            </div>
            <div class="panel-body">
                {!! Form::model($article, [ 'url' => [URL::route('admin.article.edit'), $article->id], 'method' => 'post'] )  !!}
                       
                <div class="form-group">
                    {!! Form::select('is_approved', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_approved) && $article->is_approved) ? $article->is_approved : "0" ) !!}
                    {!! Form::label("is_approved","approved: ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('is_welcome', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_welcome) && $article->is_welcome) ? $article->is_welcome : "0" ) !!}
                            {!! Form::label("is_welcome","Welcome Guide: ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('is_home_featured', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_home_featured) && $article->is_home_featured) ? $article->is_home_featured : "0" ) !!}
                            {!! Form::label("is_home_featured","Show on homepage: ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('is_homepage_sponsored', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_homepage_sponsored) && $article->is_homepage_sponsored) ? $article->is_homepage_sponsored : "0" ) !!}
                            {!! Form::label("is_homepage_sponsored","Sponsored on homepage: ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('is_shf_featured', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_shf_featured) && $article->is_shf_featured) ? $article->is_shf_featured : "0" ) !!}
                            {!! Form::label("is_shf_featured","Show on ShangHai family ") !!}
                </div>

                <div class="form-group">
                            {!! Form::select('is_shf_sponsored', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_shf_sponsored) && $article->is_shf_sponsored) ? $article->is_shf_sponsored : "0" ) !!}
                            {!! Form::label("is_shf_sponsored","Sponsored on homepage") !!}
                </div>

                <!-- article title field -->
                <div class="form-group">
                    {!! Form::label('title','title: *') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('title') !!}</span>
                <!-- article subtitle field -->
                <div class="form-group">
                    {!! Form::label('subtitle','subtitle: ') !!}
                    {!! Form::text('subtitle', null, ['class' => 'form-control', 'placeholder' => 'subtitle']) !!}
                </div>
                <!-- SEO Page Title -->
                <div class="form-group">
                    {!! Form::label('page_title','SEO Page Title:') !!}
                    {!! Form::text('page_title', null, ['class' => 'form-control', 'placeholder' => 'SEO Page Title']) !!}
                </div>
                <!-- SEO Metadescription: -->
                <div class="form-group">
                    {!! Form::label('meta_description','SEO Metadescription:') !!}
                    {!! Form::text('meta_description', null, ['class' => 'form-control', 'placeholder' => 'SEO Metadescription']) !!}
                </div>
                <span class="text-danger">{!! $errors->first('subtitle') !!}</span>
                <div class="form-group">
                            {!! Form::select('is_in_sitemap', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_in_sitemap) && $article->is_in_sitemap) ? $article->is_in_sitemap : "0" ) !!}
                            {!! Form::label("is_in_sitemap","add to sitemap") !!}
                </div>
                <div class="form-group">
                            {!! Form::select('is_proofread', [
                                1=>'Yes',
                                0=>'No',
                                ], (isset($article->is_proofread) && $article->is_proofread) ? $article->is_proofread : "0" ) !!}
                            {!! Form::label("is_proofread","is proofread ") !!}
                </div>
                {!! Form::hidden('id') !!}
                <a href="{!! URL::route('admin.article.delete',['id' => $article->id, '_token' => csrf_token()]) !!}" class="btn btn-danger pull-right margin-left-5 delete">Delete</a>
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