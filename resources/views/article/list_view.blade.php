
@extends('layouts.app')

@section('head')
    <title>Article</title>
    <link rel="stylesheet" href="/css/classified.css" type="text/css" />
@endsection


@section('content')
<div class="container">
  <div class="main_left">


    @foreach ($articles as $item)
  <div class="classified-list-item">
    <a href="{!! URL::route('article.item_view', ['id' => $item->id]) !!}">
      <img src="{{ $item->pic }}" alt="" class="list-image"/>
    </a>
    <div class="i-right">
      <div class="i1">
        <!--<a href="{{$item->get_absolute_url}}">{{ substr($item->title, 0, 100) }}</a>-->
        <a href="{!! URL::route('article.item_view', ['id' => $item->id]) !!}" title='edit'><i class="fa fa-pencil-square-o fa-2x">{{ substr($item->title, 0, 100) }}</i></a>
      </div>
      <div class="i2">
        
        <div class="i2i2">{{ substr(strip_tags($item->content), 0, 120) }}</div>
      </div>
      <div class="i3">
        <a href=""><span>Posted</span></a>
        <br />
        <span class="i3i1">{{ date("d",strtotime($item->datetime_publish)) }}</span>
        <br />
        
        <span class="i3i2">{{ date("M",strtotime($item->datetime_publish)) }}</span>
        <br />
        <span class="i3i3">{{ date("D",strtotime($item->datetime_publish)) }}</span>
      </div>
      <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
  </div>
  <div class="divide"></div>
    @endforeach
    {!! $articles->links() !!}
</div>
  <div class='main_right'>

  </div>
</div>

@endsection