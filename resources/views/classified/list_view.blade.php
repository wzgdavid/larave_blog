@extends('layouts.classified')




@section('main_left')
<div class="main_left">


  
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

       @include(config('laravel-menu.views.bootstrap-items'), array('items' => $MyNavBar->roots()))

      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    @foreach ($classifieds as $item)
  <div class="classified-list-item">
    <a href="{!! URL::route('classified.item_view', ['id' => $item->id]) !!}">
      <img src="{{ $item->get_main_image_url }}" alt="" class="list-image"/>
    </a>
    <div class="i-right">
      <div class="i1">
      	<a href="{!! URL::route('classified.item_view', ['id' => $item->id]) !!}" title='edit'><i class="fa fa-pencil-square-o fa-2x">{{ substr($item->title, 0, 100) }}</i></a>
      </div>
      <div class="i2">
        
        <div class="i2i2">{{ substr(strip_tags($item->content), 0, 120) }}</div>
      </div>
      <div class="i3">
        <a href=""><span>Posted</span></a>
        <br />
        <span class="i3i1">{{ date("d",strtotime($item->start_datetime)) }}</span>
        <br />
        
        <span class="i3i2">{{ date("M",strtotime($item->start_datetime)) }}</span>
        <br />
        <span class="i3i3">{{ date("D",strtotime($item->start_datetime)) }}</span>
      </div>
      <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
  </div>
  <div class="divide"></div>
    @endforeach
    {!! $classifieds->links() !!}
</div>

@endsection

