@extends('teachers.layout')

@section('content')

    <div class="row">
        <div class="teacherName col-xs-12 col-sm-12 col-md-12 mb-5">
            <h2>{{ $teacher->name }}</h2>
        </div>
        <div class="teacherBio col-xs-12 col-sm-12 col-md-12">
            <h3>Bio</h3>
            <img class="teacherPhoto ml-3" src="{{ $teacher->image }}" style="width:200px; float:right;">
            {!! $teacher->bio !!}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Country</h3>
            {{ $teacher->country }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Year of starting to practice</h3>
            {{ $teacher->year_starting_practice }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Year of starting to teach</h3>
            {{ $teacher->year_starting_teach }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Facebook profile</h3>
            <a href="{{ $teacher->facebook }}" target="_blank">{{ $teacher->facebook }}</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Website</h3>
            <a href="{{ $teacher->website }}" target="_blank">{{ $teacher->website }}</a>
        </div>

    </div>

@endsection
