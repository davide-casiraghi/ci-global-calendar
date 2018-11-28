@extends('events.layout')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            @include('partials.forms.event.button-report-misuse')
        </div>
    </div>


    <div class="row">
        <div class="eventTitle col-xs-12 col-sm-12 col-md-12 mb-3">
            <h2>{{ $event->title }}</h2>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
            <i class="fa fa-tag mr-2" data-toggle="tooltip" data-placement="top" title="Category"></i>
            {{ $category->name }}
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-1" style="display: table;">
            <i class="far fa-clock" data-toggle="tooltip" data-placement="top" title="Date & Time" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;"></i>
            <div class="date ml-2">
                <div class="bigdate">@date_monthname($datesTimes->start_repeat) -&nbsp;@date_monthname($datesTimes->end_repeat)</div>
                <small class="smalldate text-black-50">From @date_monthname($datesTimes->start_repeat)&nbsp;at&nbsp;@time_am_pm($datesTimes->start_repeat) to&nbsp;@date_monthname($datesTimes->end_repeat) at&nbsp;@time_am_pm($datesTimes->end_repeat)</small>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-1" style="display: table;">
            <i class="far fa-map-marker-alt" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Venue"></i>
            <div class="venue ml-2">
                {{ $venue->name }}  -  {{ $venue->address }}, {{ $venue->city }}, {{ $country->name }} - <a href="#map" name="map">Show map</a>
            </div>
        </div>

        @if(!empty($teachers))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
                <i class="far fa-users mr-1" data-toggle="tooltip" data-placement="top" title="Teachers"></i>
                @foreach ($teachers as $key => $teacher)
                    {{$teacher->name}}
                @endforeach
            </div>
        @endif

        @if(!empty($organizers))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
                <i class="fa fa-users mr-1" data-toggle="tooltip" data-placement="top" title="Organizers"></i>
                @foreach ($organizers as $key => $organizer)
                    {{$organizer->name}}
                @endforeach
            </div>
        @endif

        <div class="col-xs-12 col-sm-12 col-md-12 mt-1">
            <i class="far fa-folders mr-1" data-toggle="tooltip" data-placement="top" title="Repetitions"></i>
            The event happens every Thursday until 10/6/2018
        </div>


        <div class="eventBody col-xs-12 col-sm-12 col-md-12 mt-5">
            {!! $event->description !!}
        </div>


        @if((!empty($event->facebook_event_link))||(!empty($event->website_event_link)))
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <h3>Links</h3>
                @if(!empty($event->facebook_event_link))
                    <div class="facebook">
                        <i class="fab fa-facebook-square" style="margin-right: 10px;"></i>
                        <a href="{{ $event->facebook_event_link }}" target="_blank">{{ $event->facebook_event_link }}</a>
                    </div>
                @endif
                @if(!empty($event->website_event_link))
                    <div class="url">
                        <i class="fa fa-external-link" style="margin-right: 10px;"></i>
                        <a href="{{ $event->website_event_link }}" target="_blank">{{ $event->website_event_link }}</a>
                    </div>
                @endif
            </div>
        @endif

        <div class="col-xs-12 col-sm-12 col-md-12 mt-4">
            <h3>Location</h3>
            {{ $venue->name }}<br />
            {{ $venue->address }}<br />
            {{ $venue->city }}<br />
            {{ $venue->zip_code }}<br />
            {{ $country->name }}<br />
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mt-4" id="map">

            @include('partials.gmap', [
                  'venue_name' => $venue->name,
                  'venue_address' => $venue->address,
                  'venue_city' => $venue->city,
                  'venue_country' => $country->name,
                  'venue_zip_code' => $venue->zip_code
            ])
        </div>

    </div>

@endsection
