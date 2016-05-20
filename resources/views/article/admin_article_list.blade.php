@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: articles list
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
            <div class="col-md-12">
                {{-- print messages --}}
                <?php $message = Session::get('message'); ?>
                @if( isset($message) )
                    <div class="alert alert-success">{!! $message !!}</div>
                @endif
                {{-- print errors --}}
                @if($errors && ! $errors->isEmpty() )
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{!! $error !!}</div>
                    @endforeach
                @endif


                {{-- article lists --}}
	<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> {!! $request->all() ? 'Search results:' : 'Articles' !!}</h3>
    </div>
    <div class="panel-body">
       <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3">
                    <a href="{!! URL::route('admin.article.edit') !!}" class="btn btn-info"><i class="fa fa-plus"></i> Add New Article</a>
            </div>
       </div>
        <div class="row">
        	
            <div class="col-lg-10 col-md-9 col-sm-9">
        {!! Form::open(['route' => 'admin.article.list','method' => 'get']) !!}
        <!-- title field -->
        <div class="form-group" style="float:left;width:300px;">
            {!! Form::label('title','title: ') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
        </div>
        
        <!-- is home show field -->
        <div class="form-group" style="float:left;width:200px;">
            {!! Form::label('is_home_featured', 'Show on homepage: ') !!}
            {!! Form::select('is_home_featured', ['' => 'Any', 1 => 'Yes', 0 => 'No'], $request->get('is_home_featured',''), ["class" => "form-control"]) !!}
        </div>
        <!-- is home sponsored -->
        <div class="form-group" style="float:left;width:200px;">
            {!! Form::label('is_homepage_sponsored', 'Sponsored on homepage: ') !!}
            {!! Form::select('is_homepage_sponsored', ['' => 'Any', 1 => 'Yes', 0 => 'No'], $request->get('is_homepage_sponsored',''), ["class" => "form-control"]) !!}
        </div>
        <!-- is shf show -->
        <div class="form-group" style="float:left;width:200px;">
            {!! Form::label('is_shf_featured', 'Show on SHfamily: ') !!}
            {!! Form::select('is_shf_featured', ['' => 'Any', 1 => 'Yes', 0 => 'No'], $request->get('is_shf_featured',''), ["class" => "form-control"]) !!}
        </div>
        <!-- is shf sponsored  -->
        <div class="form-group" style="float:left;width:200px;">
            {!! Form::label('is_shf_sponsored', 'Sponsored on SHfamily: ') !!}
            {!! Form::select('is_shf_sponsored', ['' => 'Any', 1 => 'Yes', 0 => 'No'], $request->get('is_shf_sponsored',''), ["class" => "form-control"]) !!}
        </div>

        <div style="clear:both"></div>
        <div class="form-group">
            <a href="{!! URL::route('users.list') !!}" class="btn btn-default search-reset">Reset</a>
            {!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit"]) !!}
        </div>
        {!! Form::close() !!}
            </div>

        </div>

      <div class="row">
          <div class="col-md-12">
              @if(! $articles->isEmpty() )
              <table class="table table-hover">
                      <thead>
                          <tr>
                              <th>Title</th>
                              <th>Author</th>
                              <th>Priority</th>
                              <th>Homepage show</th>
                              <th>Homepage sponsor</th>
                              <th>SH Family show</th>
                              <th>SH Family sponsor</th>

                              <th>Operations</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($articles as $article)
                          <tr>
                              <td>{!! $article->title !!}</td>
                              <td>{!! $article->get_author() !!}</td>
                              <td>{!! $article->shf_priority !!}</td>
                              <td>{!! $article->is_home_featured ? '<i class="fa fa-circle green"></i>' : '<i class="fa fa-circle-o red"></i>' !!}</td>
                              <td>{!! $article->is_homepage_sponsored ? '<i class="fa fa-circle green"></i>' : '<i class="fa fa-circle-o red"></i>' !!}</td>
                              <td>{!! $article->is_shf_featured ? '<i class="fa fa-circle green"></i>' : '<i class="fa fa-circle-o red"></i>' !!}</td>
                              <td>{!! $article->is_shf_sponsored ? '<i class="fa fa-circle green"></i>' : '<i class="fa fa-circle-o red"></i>' !!}</td>

                              <td>
                                  @if(! $article->protected)
                                      <a href="{!! URL::route('admin.article.edit', ['id' => $article->id]) !!}" title='edit'><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                      <a href="{!! URL::route('admin.article.delete',['id' => $article->id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete" title='delete'><i class="fa fa-trash-o fa-2x red"></i></a>
                                  @else
                                      <i class="fa fa-times fa-2x light-blue"></i>
                                      <i class="fa fa-times fa-2x margin-left-12 light-blue"></i>
                                  @endif
                              </td>                              
                          </tr>
                      </tbody>
                      @endforeach
              </table>

              @else
                  <span class="text-warning"><h5>No results found.</h5></span>
              @endif
          </div>
      </div>
    </div>
	</div>
{{-- article lists  end--}}

            </div>

        
        </div>
</div>
@stop

@section('footer_scripts')
    <script>
        $(".delete").click(function(){
            return confirm("Are you sure to delete this item?");
        });
    </script>
@stop