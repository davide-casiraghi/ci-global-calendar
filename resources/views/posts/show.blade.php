@extends('posts.layout')

@section('title'){{ $post->title }}@endsection
@section('description'){{ Str::limit(strip_tags($post->body), $limit = 150, $end = '...') }}@endsection
    

@section('beforeContent')
    {!! $post->before_content !!}
@endsection

@section('content')
    <div class="container max-w-md px-0">
        <div class="row m-0 p-4 white-bg rounded">
            <div class="postTitle col-12 mb-4 mt-4">
                <h2>{{ $post->title }}</h2>
            </div>
            <div class="postBody col-12 text-base-longtext">
                {!! $post->body !!}
            </div>
        </div>

    </div>

@endsection


@section('afterContent')
    {!! $post->after_content !!}
@endsection
