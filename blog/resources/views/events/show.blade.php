@extends('events.layout')

@section('content')

    <div class="row">
        <div class="eventTitle col-xs-12 col-sm-12 col-md-12 mb-4">
            <h2>{{ $event->title }}</h2>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mb-1">
            <i class="fa fa-tag" style="margin-right: 10px;"></i>
            {{ $category->name }}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mb-1">
            <i class="far fa-clock"></i>
            <div class="date">
                <div class="bigdate">21 Nov 2018 -&nbsp;22 Nov 2018</div>
                <div class="smalldate">From 21 Nov 2018&nbsp;at&nbsp;12:30am to&nbsp;22 Nov 2018 at&nbsp;02:30am</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-1">
            <i class="fa fa-map-marker" style="margin-right: 10px;"></i>
            {{ $venue->name }}  -  {{ $venue->address }}, {{ $venue->city }}, {{ $country->name }} - Show map
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <i class="fa fa-users" style="margin-right: 10px;"></i>
            @foreach ($organizers as $key => $organizer)
                {{$organizer->name}}
            @endforeach
        </div>

        <div class="eventBody col-xs-12 col-sm-12 col-md-12 mt-5">
            {!! $event->description !!}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <h3>Links</h3>
            <div class="facebook">
                <i class="fab fa-facebook-square" style="margin-right: 10px;"></i>
                {{ $event->facebook }}
            </div>
            <div class="url">
                <i class="fa fa-external-link" style="margin-right: 10px;"></i>
                {{ $event->website }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Location</h3>
            <p>{{ $venue->name }}</p>
            <p>{{ $venue->address }}</p>
            <p>{{ $venue->zip_code }}</p>
            <p>{{ $country->name }}</p>
        </div>





    </div>

@endsection
