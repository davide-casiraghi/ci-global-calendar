@extends('organizers.layout')

@section('content')

    <div class="row">
        <div class="teacherName col-xs-12 col-sm-12 col-md-12 mb-5">
            <h2>{{ $organizer->name }}</h2>
        </div>

        @if(!empty($organizer->facebook))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <h3>Facebook profile</h3>
                <a href="{{ $organizer->facebook }}" target="_blank">{{ $organizer->facebook }}</a>
            </div>
        @endif

        @if(!empty($organizer->website))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <h3>Website</h3>
                <a href="{{ $organizer->website }}" target="_blank">{{ $organizer->website }}</a>
            </div>
        @endif

        @if(!empty($eventVenue->description))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <h3>Description</h3>
                {!! $organizer->description !!}
            </div>
        @endif

    </div>

@endsection
