@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: articles list
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
            <div class="col-md-9">
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
        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> {!! $request->all() ? 'Search results:' : 'Users' !!}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
        	<!-- ordering
            <div class="col-lg-10 col-md-9 col-sm-9">
                {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
                    <div class="form-group">
                        {!! Form::select('order_by', ["" => "select column", "first_name" => "First name", "last_name" => "Last name", "email" => "Email", "last_login" => "Last login", "active" => "Active"], $request->get('order_by',''), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::select('ordering', ["asc" => "Ascending", "desc" => "descending"], $request->get('ordering','asc'), ['class' =>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Order', ['class' => 'btn btn-default']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            -->
            <div class="col-lg-2 col-md-3 col-sm-3">
                    <a href="{!! URL::route('admin.article.edit') !!}" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>
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
            <div class="col-md-3">
            	{{-- article search --}}

                {{-- article search end --}}
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