@extends('posts.layout')

@section('title'){{ $post->title }}@endsection

@section('beforeContent')
    {!! $post->before_content !!}
@endsection

@section('content')

    <div class="row">
        <div class="postTitle col-12 mb-4 mt-5">
            <h2>{{ $post->title }}</h2>
        </div>
        <div class="postBody col-12">
            {!! $post->body !!}
        </div>
    </div>

    {{--<div class="row">
        <div class="col-12">
            <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
        <div class="col-12">
    </div>--}}

@endsection


@section('afterContent')
    {!! $post->after_content !!}
@endsection
