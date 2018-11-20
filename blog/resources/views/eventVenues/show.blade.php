@extends('events.layout')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h2>{{ $eventVenue->name }}</h2>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            {{ $eventVenue->address }}<br />
            {{ $eventVenue->city }}<br />
            {{ $country->name }}<br />
            {{ $eventVenue->zip_code }}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            {!! $eventVenue->description !!}
        </div>

        @if(!empty($eventVenue->website))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <strong>Website</strong><br />
                <a href="{{ $eventVenue->website }}" target="_blank">{{ $eventVenue->website }}</a>
            </div>
        @endif

        @if(!empty($eventVenue->facebook))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
                <strong>Facebook</strong><br />
                <a href="{{ $eventVenue->facebook }}" target="_blank">{{ $eventVenue->facebook }}</a>
            </div>
        @endif


        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            @include('partials.gmap', [
                  'venue_name' => $eventVenue->name,
                  'venue_address' => $eventVenue->address,
                  'venue_city' => $eventVenue->city,
                  'venue_country' => $country->name,
                  'venue_zip_code' => $eventVenue->zip_code
            ])
        </div>

    </div>


@endsection
