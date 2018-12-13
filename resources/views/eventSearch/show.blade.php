@extends('eventSearch.layout')

@section('content')

    <div class="row">
        <div class="eventTitle col-12 mb-5">
            <h2>{{ $event->title }}</h2>
        </div>
        <div class="eventBody col-12">
            {!! $event->description !!}
        </div>
    </div>

@endsection
