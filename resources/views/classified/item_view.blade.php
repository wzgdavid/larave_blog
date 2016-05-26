@extends('layouts.app')

@section('head')
    <title>Classified</title>
    <link rel="stylesheet" href="/css/classified.css" type="text/css" />
@endsection


@section('content')
<div class="container">
  <div class="classified-item-right">
    <div class="cr1">{{$item->title}}</div>
    @if( $item->is_approved == 0 )
    <div class="cr3">
      (UnApproved)
    </div>
    @endif
    <div class="cr4">
      {{$item->price}}
      @if( isset($item->start_datetime) ) | @endif
      
      {{ date("d m y",strtotime($item->start_datetime)) }}
      @if( isset($item->end_datetime) ) to @endif
      
      {{ date("d m y",strtotime($item->end_datetime)) }}
    </div>
    @if( $item->is_individual == 1 )
    <div class="cr5"><span class="label label-info">Individual Listing</span></div>
    @endif

    <div class="cr6">
      <div><img src="{% replace_none $item->get_main_image_url default_main_img%}" alt="" /></div>
      
      <div style="clear:both"></div>
    </div>
    <div class="cr7">Features & Description</div>
    <div class="cr8">
      <div class="cr8-l">
        Area:<br />
        
        @if( $item->district_id != 0 )
        <span class="sp1">{{$item->district_id}}</span>
        @endif
        <br />
        Rent:<br />
        <span class="sp2">{{$item->price}}</span>
        <br />
      </div>
      <div class="cr8-r">
        {{$item->content}}
        <br />
        
        <div class="clear_both"></div>
        <input id="id_geo_location" name="geo_location" step="0.000001" type="text" value="" class="no-display" style="display:none">

      </div>
      <div class="clear_both"></div>
    </div>


  </div>
</div>

@endsection

