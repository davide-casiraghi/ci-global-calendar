@extends('eventCategories.layout')

@section('content')

    <div class="row">
        <div class="eventTitle col-xs-12 col-sm-12 col-md-12 mb-5">
            <h2>{{ $eventCategory->title }}</h2>
        </div>
        <div class="eventBody col-xs-12 col-sm-12 col-md-12">
            {!! $eventCategory->description !!}
        </div>
    </div>

@endsection
