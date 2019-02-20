@extends('events.layout')

@section('title'){{ $event->title }}@endsection
@section('description'){{ $category->name }} @ {{ $venue->name }} - {{ $venue->city }}, {{ $country->name }}@endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $event->title }} - {{ $venue->name }} - {{ $venue->city }}, {{ $country->name }}" />
    @if(!empty($event->image))
        <meta property="og:image" content="/storage/images/events_teaser/{{ $event->image }}" />
    @else
        <meta property="og:image" content="/storage/logo/fb_logo_cigc_red.jpg" />
    @endif
    
@endsection    
    
@section('content')
    <div class="container max-w-md px-0">
        
        {{-- Event Intro --}}
            <div class="row">
                <div class="col-12 pt-4 px-4 white-bg rounded">
                    <div class="row">
                        <div class="eventTitle col-12 mb-3 mt-3">
                            <h4>{{ $event->title }}</h4>
                        </div>
                        
                    </div>
                    <div class="row">    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <i class="fa fa-tag mr-2 dark-gray" data-toggle="tooltip" data-placement="top" title="Category"></i>
                                    {{ $category->name }}
                                </div>

                                <div class="col-12 mt-2" style="display: table;">
                                    <i class="far fa-clock dark-gray" data-toggle="tooltip" data-placement="top" title="Date & Time" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;"></i>
                                    <div class="date ml-2">
                                        <div class="bigdate">@date_monthname($datesTimes->start_repeat) @if(!$sameDateStartEnd)-&nbsp;@date_monthname($datesTimes->end_repeat)@endif</div>
                                        <small class="smalldate text-black-50">From @date_monthname($datesTimes->start_repeat)&nbsp;at&nbsp;@time_am_pm($datesTimes->start_repeat) to @if(!$sameDateStartEnd)@date_monthname($datesTimes->end_repeat) at @endif @time_am_pm($datesTimes->end_repeat)</small>
                                    </div>
                                </div>
                                <div class="col-12 mt-2" style="display: table;">
                                    <i class="far fa-map-marker-alt dark-gray" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Venue"></i>
                                    <div class="venue ml-2">
                                        {{ $venue->name }}  -  {{ $venue->address }}, {{ $venue->city }}, {{ $country->name }} - <a href="#map" name="map">Show map</a>
                                    </div>
                                </div>

                                @if(count($teachers))
                                    <div class="col-12 mt-2">
                                        <i class="far fa-users mr-1 dark-gray" data-toggle="tooltip" data-placement="top" title="Teachers"></i>
                                        @foreach ($teachers as $key => $teacher)
                                            <a href="/teacher/{{$teacher->slug}}">{{$teacher->name}}</a>@if(!$loop->last),@endif
                                        @endforeach
                                    </div>
                                @endif

                                @if(count($organizers))
                                    <div class="col-12 mt-2">
                                        <i class="fa fa-users mr-1 dark-gray" data-toggle="tooltip" data-placement="top" title="Organizers"></i>
                                        @foreach ($organizers as $key => $organizer)
                                            {{$organizer->name}}
                                        @endforeach
                                    </div>
                                @endif

                                @if(!empty($repetition_text))
                                    <div class="col-12 col-sm-12 col-md-12 mt-2">
                                        <i class="far fa-folders mr-1 dark-gray" data-toggle="tooltip" data-placement="top" title="Repetitions"></i>
                                        {{-- The event happens every Thursday until 10/6/2018--}}
                                        {{$repetition_text}}
                                    </div>
                                @endif
                            </div>
                        </div>
                
                    </div>
                    
                    {{-- Links --}}
                        <div class="row mt-2">
                            @if(!empty($event->facebook_event_link))
                                <div class="col-6">
                                    <i class="fab fa-facebook-square dark-gray" style="margin-right: 10px;"></i>
                                    <a href="{{ $event->facebook_event_link }}" target="_blank">Facebook Event</a>
                                </div>
                            @endif
                            @if(!empty($event->website_event_link))
                                <div class="col-6">
                                    <i class="fa fa-external-link dark-gray" style="margin-right: 10px;"></i>
                                    <a href="{{ $event->website_event_link }}" target="_blank">Website</a>    
                                </div>
                            @endif
                        </div>
                        
                    {{-- Write to the organizer --}}
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12">
                                @include('partials.forms.event.button-write-to-organizer')
                            </div>
                        </div>
                </div>
            </div>
        
        {{-- Event Body --}}
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 mt-3 p-4 white-bg rounded text-base-longtext">
                    @if(!empty($event->image))
                        <img class="eventPhoto ml-4 mb-4 float-right" alt="{{ $event->title }} - {{ $venue->name }} - {{ $venue->city }}, {{ $country->name }}" src="/storage/images/events_teaser/thumb_{{ $event->image }}" style="max-width:300px; ">
                    @endif
                    {!! $event->description !!}    
                </div>
            </div>
        
        {{-- Misuse button --}}
            <div class="row">
                <div class="col-12 mt-3 p-0">
                    @include('partials.forms.event.button-report-misuse')
                </div>
            </div>

        {{-- Location --}}
            <div class="row">
                <div class="col-12 mt-4 p-4 white-bg rounded">
                    <h3>{{ $venue->name }}</h3>
                    {{ $venue->address }}<br />
                    {{ $venue->city }}<br />
                    {{ $venue->zip_code }}<br />
                    <b>{{ $country->name }}</b><br />
                </div>
                
                <div class="col-12 mt-4 p-0" id="map">
                    @include('partials.gmap', [
                          'venue_name' => $venue->name,
                          'venue_address' => $venue->address,
                          'venue_city' => $venue->city,
                          'venue_country' => $country->name,
                          'venue_zip_code' => $venue->zip_code
                    ])
                </div>
            </div>

    </div>
@endsection
