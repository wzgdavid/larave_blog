@extends('layouts.app')

@section('head')
    <title>article</title>
@endsection


@section('content')
<div class="container">
{{$article->title}}
</div>
<div class="container">
{{$article_category->name}}
</div>
@endsection
