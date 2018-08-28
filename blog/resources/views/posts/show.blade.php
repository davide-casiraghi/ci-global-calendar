@extends('posts.layout')


@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h2>{{ $post->title }}</h2>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            {!! $post->body !!}
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
        <div class="col-xs-12 col-sm-12 col-md-12">
    </div>

@endsection
