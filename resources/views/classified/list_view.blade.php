@extends('layouts.app')

@section('head')
    <title>Classified</title>
    <link rel="stylesheet" href="/css/classified.css" type="text/css" />
@endsection


@section('content')
<div class="container">
    @foreach ($classifieds as $item)
          <div class="classified-list-item">
    <a href="{{$item->get_absolute_url}}"><img src="{%replace_none $item->get_main_image_url default_main_img%}" alt="" class="list-image"/></a>
    <div class="i-right">
      <div class="i1">
      	<!--<a href="{{$item->get_absolute_url}}">{{ substr($item->title, 0, 100) }}</a>-->
      	<a href="{!! URL::route('classified.item_view', ['id' => $item->id]) !!}" title='edit'><i class="fa fa-pencil-square-o fa-2x">{{ substr($item->title, 0, 100) }}</i></a>
      </div>
      <div class="i2">
        
        <div class="i2i2">{{ substr($item->content, 0, 120) }}</div>
      </div>
      <div class="i3">
        <a href=""><span>Posted</span></a>
        <br />
        <span class="i3i1">{{ date("d",strtotime($item->start_datetime)) }}</span>
        <br />
        
        <span class="i3i2">{{ date("y-m",strtotime($item->start_datetime)) }}</span>
        <br />
        <!--<span class="i3i3">{{$item->start_datetime}}</span>-->
      </div>
      <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
  </div>
  <div class="divide"></div>
    @endforeach
</div>
{!! $classifieds->links() !!}
@endsection

