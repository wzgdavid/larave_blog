
@extends('layouts.app')

@section('head')
    <title>Article</title>
    <link rel="stylesheet" href="/css/classified.css" type="text/css" />
@endsection


@section('content')
<div class="container">
  <div class="main_left">
      <h1>{{$item->title}}</h1>
      @if( isset($item->subtitle) )
      <h2>{{$item->subtitle}}</h2>
      @endif

        <div class="">
        {!! $item->content !!}
      </div>
</div>
  <div class='main_right'>

  </div>
</div>

@endsection