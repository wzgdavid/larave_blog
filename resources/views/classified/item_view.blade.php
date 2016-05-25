@extends('layouts.app')

@section('head')
    <title>Classifies</title>
    <link rel="stylesheet" href="/css/classified.css" type="text/css" />
@endsection


@section('content')
<div class="container">
  <div class="classified-item-right">
    <div class="cr1">{{$item->title}}</div>
    {% if can_edit and not $item->is_approved %}
    <div class="cr3">
      (UnApproved)
    </div>
    {% endif %}
    <div class="cr4">
      {{$item->price}}
      {% if $item->start_datetime %}|{%endif%}
      {{$item->start_datetime|date:"d F Y"}}
      {% if $item->end_datetime %} to {%endif%}
      {{$item->end_datetime|date:"d F Y"}} 
    </div>
    {%if $item->is_individual%}
    <div class="cr5"><span class="label label-info">Individual Listing</span></div>
    {%endif%}
    <div class="cr6">
      <div><img src="{% replace_none $item->get_main_image_url default_main_img%}" alt="" /></div>
      <div class="view_other_thumbnail">View all <a href="{{$item->get_genericimage_gallery_url}}" target="blank">{{$item->images.count}} photos</a></div>
      <div style="clear:both"></div>
    </div>
    <div class="cr7">Features & Description</div>
    <div class="cr8">
      <div class="cr8-l">
        Area:<br />
        {%if $item->district%}
        <span class="sp1">{{$item->district}}</span>
        {%endif%}
        <br />
        Rent:<br />
        <span class="sp2">{{$item->price}}</span>
        <br />
      </div>
      <div class="cr8-r">
        {{$item->content|striptags|content_formater|safe}}
        <br />
        <a href="mailto:{{$item->contributor.email}}"><button class="btn classified-custom-button2">contact the poster</button></a>
        <div class="clear_both"></div>
        <input id="id_geo_location" name="geo_location" step="0.000001" type="text" value="" class="no-display" style="display:none">

        <div class="cr9">
          {% include "misc/share_with.html" %}
        </div>
        <div>
        {%if $item->forum_url%}
        <a href="{{$item->forum_url}}">View Classified discussion in the forum</a>
        {%endif%}
        </div>

      </div>
      <div class="clear_both"></div>
    </div>


  </div>
</div>

@endsection

