@extends('laravel-authentication-acl::admin.layouts.base')

@section('container')
    <div class="content-wrapper">
        <div class="content-header">
        	<ul class="nav" >
                @if(isset($sidebar_items) && $sidebar_items)
                    @foreach($sidebar_items as $name => $data)
                        <li class="{!! LaravelAcl\Library\Views\Helper::get_active($data['url']) !!}"><a href="{!! $data['url'] !!}">{!! $data['icon'] !!} {{$name}}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
@stop