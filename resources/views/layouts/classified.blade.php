@extends('layouts.app')

@section('head')
    <title>Classified</title>
    <link rel="stylesheet" href="/css/classified.css" type="text/css" />
@endsection


@section('content')
<div class="container">
	@yield('main_left')
	<div class='main_right'>
        <p>
            <a class="fast-post-submit" href="/classified/edit_view">Post classified</a>
        </p>
	</div>
</div>

@endsection