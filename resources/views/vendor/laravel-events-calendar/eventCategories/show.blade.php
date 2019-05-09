@extends('laravel-events-calendar::eventCategories.layout')

@section('content')

    <div class="row">
        <div class="eventTitle col-12 mb-5">
            <h2>{{ $eventCategory->title }}</h2>
        </div>
        <div class="eventBody col-12">
            {!! $eventCategory->description !!}
        </div>
    </div>

@endsection
