@extends('laravel-events-calendar::events.layout')

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
            <div class="row event-wrapper">
                <div class="col-12 white-bg rounded">
                    <div class="row p-2">
                        <div class="col-12 col-md-8 mb-3 mt-3">
                            <h4 class="event-title">{{ $event->title }}</h4>
                        </div>
                        <div class="col-12 col-md-4 text-right my-0 my-md-3">
                            {{-- Write to the organizer --}}
                            @include('laravel-events-calendar::partials.event.button-write-to-organizer')
                        </div>
                    </div>
                    <div class="row p-2 pb-3">    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <i class="fa fa-tag mr-2 dark-gray" data-toggle="tooltip" data-placement="top" title="Category"></i>
                                    {{ $category->name }}
                                </div>

                                <div class="col-12 mt-2 d-table">
                                    <i class="far fa-clock dark-gray d-table-cell align-middle text-center pr-2" data-toggle="tooltip" data-placement="top" title="Date & Time" style="width: 20px;"></i>
                                    <div class="date event-date ml-1">
                                        <div class="bigdate">@date_monthname($datesTimes->start_repeat) @if(!$sameDateStartEnd)-&nbsp; @date_monthname($datesTimes->end_repeat)@endif</div>
                                        <small class="smalldate text-black-50">{{-- FROM --}} @date_monthname($datesTimes->start_repeat) @ @time_am_pm($datesTimes->start_repeat) {{-- toSuffix --}} @if(!$sameDateStartEnd)@date_monthname($datesTimes->end_repeat) @ @endif @time_am_pm($datesTimes->end_repeat)</small>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 d-table">
                                    <i class="fas fa-map-marker-alt dark-gray d-table-cell align-middle text-center pr-2" style="width: 20px;" data-toggle="tooltip" data-placement="top" title="Venue"></i>
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
                                            <a href="/organizer/{{$organizer->slug}}">{{$organizer->name}}</a>@if(!$loop->last),@endif
                                        @endforeach
                                    </div>
                                @endif

                                @if(!empty($repetition_text))
                                    <div class="col-12 col-sm-12 col-md-12 mt-2 d-table">
                                        <i class="far fa-folders dark-gray d-table-cell align-middle pr-2" data-toggle="tooltip" data-placement="top" title="Repetitions" style="width: 20px;"></i>
                                        {{-- The event happens every Thursday until 10/6/2018--}}
                                        {{$repetition_text}}    
                                    </div>
                                @endif
                            </div>
                        </div>
                
                    </div>
                    
                    {{-- Links --}}
                        @if((!empty($event->facebook_event_link))||(!empty($event->website_event_link)))
                            <div class="row mt-2 border-top py-3 px-2">
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
                        @endif
                        
                    
                </div>
            </div>
        
        {{-- Event Body / Image --}}
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 mt-3 p-4 white-bg rounded text-base-longtext">
                    @if(!empty($event->image))
                        <img class="ml-sm-3 float-sm-right img-fluid" alt="{{ $event->title }} - {{ $venue->name }} - {{ $venue->city }}, {{ $country->name }}" src="/storage/images/events_teaser/thumb_{{ $event->image }}">
                    @endif
                    {!! $event->description !!}    
                </div>
            </div>
        
        {{-- Misuse button --}}
            <div class="row">
                <div class="col-12 mt-3 p-0 text-right mb-4">
                    @include('laravel-events-calendar::partials.event.button-report-misuse')
                </div>
            </div>

        {{-- Location --}}
            <div class="row event-venue">
                <div class="col-12 mt-4 p-4 white-bg rounded event-venue">
                    <h4>{{ $venue->name }}</h4>
                    <div class="address">
                        {{ $venue->address }}<br />
                        @if(!empty($eventVenue->extra_info)){!! $eventVenue->extra_info !!}<br>@endif
                        {{ $venue->city }}<br />
                        @if(!empty($region->name)){{ $region->name }}<br /> @endif
                        {{ $venue->zip_code }}<br />
                        <b>{{ $country->name }}</b><br />
                    </div>
                    
                    @if(!empty($venue->website))
                        <br>
                        <i class="fa fa-external-link dark-gray" style="margin-right: 10px;"></i>
                        <a href="{{ $venue->website }}" target="_blank">{{ $venue->website }}</a>    
                        <br /><br />
                    @endif
                    
                    {!! $venue->description !!}<br />
                </div>
                
                <div class="col-12 mt-4 p-0" id="map">
                    @include('laravel-events-calendar::partials.gmap', [
                          'venue_name' => $venue->name,
                          'venue_address' => $venue->address,
                          'venue_city' => $venue->city,
                          'venue_country' => $country->name,
                          'venue_zip_code' => $venue->zip_code
                    ])
                </div>
            </div>

    </div>
    
    {{-- Google Structured datas --}}
    <script type="application/ld+json">
	{
		"startDate":"{{Carbon\Carbon::parse($datesTimes->start_repeat)->toIso8601String()}}",
		"endDate":"{{Carbon\Carbon::parse($datesTimes->end_repeat)->toIso8601String()}}",
		"name":"{{ $event->title }}",
        "about":"Contact Improvisation",
		"url":"{{Request::url()}}",
		@if(!empty($event->image)) 
            "image":"/storage/images/events_teaser/{{ $event->image }}", 
        @else
            "image":"/storage/logo/fb_logo_cigc_red.jpg", 
        @endif
		"eventStatus":"EventScheduled",
		"location":{
			"address":
				{
					"addressCountry":"{{$country->name}}",
					"addressLocality":"{{$country->name}}",
					"addressRegion":"{{$country->name}}",
					"streetAddress":"{{$venue->address}}",
					"postalCode":"{{$venue->zip_code}}",
                    "@type":"PostalAddress"
				},
			"@type":"Place",
			"name":"{{$venue->name}}"
		},
		"@context":"http://schema.org",
		{{-- "organizer":{
				"url":"https://www.eventbrite.ca/o/idriz-dragonjic-zig-25383244579",
				"@type":"Organization",
				"name":"Idriz Dragonjic-\u201cZig\u201d"
			},--}}
		"@type":"DanceEvent",
		"description":"{{ strip_tags($event->description) }} "
	}
    </script>
    
@endsection
