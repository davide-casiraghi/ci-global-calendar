@extends('laravel-events-calendar::eventVenues.layout')

@section('title'){{ $eventVenue->name }}@endsection
@section('description')Venue profile @ Global CI calendar @endsection

@section('content')

    <div class="row">
        <div class="col-12 mb-4">
            <h2>{{ $eventVenue->name }}</h2>
        </div>

        <div class="col-12">
            @if(!empty($eventVenue->address)) {{ $eventVenue->address }}<br /> @endif
            @if(!empty($eventVenue->city)) {{ $eventVenue->city }}<br /> @endif
            @if(!empty($eventVenue->state_province)) {{ $eventVenue->state_province }}<br /> @endif
            @if(!empty($country->name)) {{ $country->name }}<br /> @endif
            @if(!empty($eventVenue->zip_code)) {{ $eventVenue->zip_code }} @endif
        </div>
        
        @if(!empty($eventVenue->extra_info))
            <div class="col-12 mt-4">
                <h4>@lang('laravel-events-calendar::eventVenue.extra_info')</h4>
                {!! $eventVenue->extra_info !!}
            </div>
        @endif

        @if(!empty($eventVenue->description))
            <div class="col-12 mt-4">
                <h4>@lang('laravel-events-calendar::general.description')</h4>
                {!! $eventVenue->description !!}
            </div>
        @endif

        @if(!empty($eventVenue->website))
            <div class="col-12 mt-4">
                <strong>@lang('laravel-events-calendar::general.website')</strong><br />
                <a href="{{ $eventVenue->website }}" target="_blank">{{ $eventVenue->website }}</a>
            </div>
        @endif


        <div class="col-12 mt-4">
            @include('laravel-events-calendar::partials.gmap', [
                  'venue_name' => $eventVenue->name,
                  'venue_address' => $eventVenue->address,
                  'venue_city' => $eventVenue->city,
                  'venue_country' => $country->name,
                  'venue_zip_code' => $eventVenue->zip_code
            ])
        </div>

    </div>


@endsection
