@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
    Admin area: articles list
@stop

@section('content')

@stop

@section('footer_scripts')
    <script>
        $(".delete").click(function(){
            return confirm("Are you sure to delete this item?");
        });
    </script>
@stop