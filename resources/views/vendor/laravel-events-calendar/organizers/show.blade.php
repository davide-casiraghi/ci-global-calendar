@extends('laravel-events-calendar::organizers.layout')

@section('title'){{ $organizer->name }}@endsection
@section('description')Organizer profile @ Global CI calendar @endsection

@section('content')

    <div class="row">
        <div class="teacherName col-12 mb-5">
            <h2>{{ $organizer->name }}</h2>
        </div>

        @if(!empty($organizer->facebook))
            <div class="col-12 mt-4">
                <h3>Facebook profile</h3>
                <a href="{{ $organizer->facebook }}" target="_blank">{{ $organizer->facebook }}</a>
            </div>
        @endif

        @if(!empty($organizer->website))
            <div class="col-12 mt-4">
                <h3>Website</h3>
                <a href="{{ $organizer->website }}" target="_blank">{{ $organizer->website }}</a>
            </div>
        @endif

        @if(!empty($organizer->description))
            <div class="col-12 mt-4">
                <h3>Description</h3>
                {!! $organizer->description !!}
            </div>
        @endif

    </div>

@endsection
