@extends('organizers.layout')

@section('content')

    <div class="row">
        <div class="teacherName col-xs-12 col-sm-12 col-md-12 mb-5">
            <h2>{{ $organizer->name }}</h2>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Facebook profile</h3>
            <a href="{{ $organizer->facebook }}" target="_blank">{{ $organizer->facebook }}</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Website</h3>
            <a href="{{ $organizer->website }}" target="_blank">{{ $organizer->website }}</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Image</h3>
            <img class="organizerPhoto ml-3" src="{{ $organizer->image }}" style="width:200px;">
        </div>

    </div>

@endsection
