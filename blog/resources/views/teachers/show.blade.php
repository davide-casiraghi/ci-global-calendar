@extends('teachers.layout')

@section('content')

    <div class="row">
        <div class="teacherName col-12 mb-5">
            <h2>{{ $teacher->name }}</h2>
        </div>

        @if(!empty($teacher->bio))
            <div class="teacherBio col-12">
                <h3>Bio</h3>
                <img class="teacherPhoto ml-3" src="{{ $teacher->profile_picture }}" style="width:200px; float:right;">
                {!! $teacher->bio !!}
            </div>
        @endif

        @if(!empty($country->name))
            <div class="col-12 mt-4">
                <h3>Country</h3>
                {{ $country->name }}
            </div>
        @endif

        @if(!empty($teacher->year_starting_practice))
            <div class="col-12 mt-4">
                <h3>Year of starting to practice</h3>
                {{ $teacher->year_starting_practice }}
            </div>
        @endif

        @if(!empty($teacher->year_starting_teach))
            <div class="col-12 mt-4">
                <h3>Year of starting to teach</h3>
                {{ $teacher->year_starting_teach }}
            </div>
        @endif

        @if(!empty($teacher->facebook))
            <div class="col-12 mt-4">
                <h3>Facebook profile</h3>
                <a href="{{ $teacher->facebook }}" target="_blank">{{ $teacher->facebook }}</a>
            </div>
        @endif

        @if(!empty($teacher->website))
            <div class="col-12 mt-4">
                <h3>Website</h3>
                <a href="{{ $teacher->website }}" target="_blank">{{ $teacher->website }}</a>
            </div>
        @endif

    </div>

@endsection
