@extends('teachers.layout')

@section('title'){{ $teacher->name }}@endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $teacher->name }}" />
@endsection    

@section('content')

    <div class="row">
        <div class="teacherName col-12 mb-5">
            <h2>{{ $teacher->name }}</h2>
        </div>

        @if(!empty($teacher->bio))
            <div class="teacherBio col-12">
                <h3>Bio</h3>
                <img class="teacherPhoto ml-3" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" style="width:345px; float:right;">
                {!! $teacher->bio !!}
            </div>
        @endif

        @if(!empty($country->name))
            <div class="col-12 mt-4">
                <b>Country:</b>
                {{ $country->name }}
            </div>
        @endif

        @if(!empty($teacher->year_starting_practice))
            <div class="col-12 mt-4">
                <b>Year of starting to practice:</b>
                {{ $teacher->year_starting_practice }}
            </div>
        @endif

        @if(!empty($teacher->year_starting_teach))
            <div class="col-12 mt-4">
                <b>Year of starting to teach:</b>
                {{ $teacher->year_starting_teach }}
            </div>
        @endif

        @if(!empty($teacher->facebook))
            <div class="col-12 mt-4">
                <b>Facebook profile:</b>
                <a href="{{ $teacher->facebook }}" target="_blank">{{ $teacher->facebook }}</a>
            </div>
        @endif

        @if(!empty($teacher->website))
            <div class="col-12 mt-4">
                <b>Website:</b>
                <a href="{{ $teacher->website }}" target="_blank">{{ $teacher->website }}</a>
            </div>
        @endif
        
        <div class="col-12 mt-4">
            <h4>This teacher will also teach in this events</h4>
        </div>

    </div>

@endsection
