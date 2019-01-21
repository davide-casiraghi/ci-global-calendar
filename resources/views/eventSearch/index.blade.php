{{-- @extends('layouts.app') --}}
@extends('layouts.hpEventSearch')

@section('javascript-document-ready')
    @parent

    {{--  Smooth Scroll on search - when we have anchor on the url --}}
        if ( window.location.hash ) scroll(0,0); {{-- to top right away --}}
        setTimeout( function() { scroll(0,0); }, 1); {{-- void some browsers issue --}}

        if(window.location.hash) {
            {{-- smooth scroll to the anchor id --}}
            $('html, body').animate({
                scrollTop: $(window.location.hash).offset().top + 'px'
            }, 1300, 'swing');
            
        }

@stop

@section('beforeContent')

    {{-- This is to show the user activation message in homepage to the Admin, when click on the user activation link --}}
        @if(session()->has('message'))
            <div class="alert alert-success" style="z-index:3;">
                {{ session()->get('message') }}
            </div>
        @endif

    {{-- The event search interface in Homepage --}}
    <div class="eventSearch jumbotron">
        @include('partials.jumboBackgroundChange')
        <div class="container">
            <div class="row intro">
                <div class="col-12 text-center">

                    <h1 class="text-white mb-3">@lang('homepage-serach.contact_improvisation')</h1>
                    <h4 class="text-uppercase"><strong>- @lang('homepage-serach.global_calendar') -</strong></h4>
                    <p class="subtitle text-white">
                        @lang('homepage-serach.find_information')<br />
                        @lang('homepage-serach.under_costruction')
                    </p>
                    <p class="searchHere text-white mt-5">
                        @lang('homepage-serach.criteria')
                    </p>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-4">
                    <p>{{ $message }}</p>
                </div>
            @endif
             
            
            {{-- Search form --}}
            {{--<form class="searchForm" action="{{ route('eventSearch.index') }}" method="GET">--}}
            <form class="searchForm" action="/eventSearch#dataarea" method="GET">
                {{--@csrf--  CSRF is just for POST requests }}

                {{--<div class="row mt-3">
                    <div class="form-group col-12">
                        <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by event name" value="{{ $searchKeywords }}">
                    </div>
                </div>--}}

                <div class="row">
                    <div class="col-md-4">
                        
                        {{-- WHAT --}}
                            <p><strong class="text-white">@lang('homepage-serach.what')</strong></p>
                            
                            @include('partials.forms.select', [
                                  'title' =>  '',
                                  'name' => 'category_id',
                                  'placeholder' => __('homepage-serach.all_kind_of_events'),
                                  'records' => $eventCategories,
                                  'seleted' => $searchCategory,
                                  'liveSearch' => 'true',
                                  'mobileNativeMenu' => 'true',
                            ])
                        
                        {{-- WHO --}}
                            <p class="mt-3"><strong class="text-white">@lang('homepage-serach.who')</strong></p>
                            
                            @include('partials.forms.event-search.select-teacher')
                            
                    </div>
                    <div class="col-md-4">
                        <p class="text-white">
                            <strong>@lang('homepage-serach.where')</strong>
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="@lang('homepage-serach.where_tooltip')"></i>
                        </p>
                        @include('partials.forms.event-search.select-continent')
                        @include('partials.forms.event-search.select-country')
                        <p class="mt-3"><strong class="text-white">@lang('homepage-serach.search_by_venue')</strong></p>
                        @include('partials.forms.input', [
                              'title' => '',
                              'name' => 'venue_name',
                              'placeholder' => __('homepage-serach.venue_name'),
                              'value' => $searchVenue
                        ])
                    </div>
                    <div class="col-md-4">
                        <p class="text-white">
                            <strong>@lang('homepage-serach.when')</strong>
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="@lang('homepage-serach.when_tooltip')"></i>
                        </p>
                        @include('partials.forms.event-search.input-date-start')
                        @include('partials.forms.event-search.input-date-end')
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-sm-10 mt-3">
                        <a id="resetButton" class="btn btn-info float-right ml-2" href="{{ URL::route('home') }}">@lang('general.reset')</a>
                        <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
                    </div>
                </div>
                
            </form>

            @if (Route::is('eventSearch.index'))  {{-- Show search results just when search button is pressed --}}
                {{-- List of events --}}
                <a id="dataarea"></a> {{-- Anchor to scroll on search --}}
                <div class="row mt-5">
                    <div class="col-7 col-md-9"></div>
                    <div class="col-5 col-md-3 bg-light text-right py-1">
                        <small>{{$events->total()}} Results found</small>
                    </div>
                </div>
                <div class="eventList mb-3">
                    @foreach ($events as $event)
                        <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                            <div class="col-lg-1 date">
                                <div class="row text-uppercase">

                                {{-- One day event --}}
                                @if (Carbon\Carbon::parse($event->start_repeat)->format('d-m-Y') == Carbon\Carbon::parse($event->end_repeat)->format('d-m-Y'))
                                    <div class='dateBox col text-center bg-secondary text-white px-2 vcenter' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                                        <strong>
                                            @day($event->start_repeat)<br class="d-none d-lg-block"/>
                                            @month($event->start_repeat)
                                        </strong>
                                    </div>
                                {{-- Many days event --}}
                                @else
                                    <div class='col text-center bg-secondary text-white px-1 mr-1' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                                        <strong>
                                            @day($event->start_repeat)<br class="d-none d-lg-block"/>
                                            @month($event->start_repeat)
                                        </strong>
                                    </div>
                                    <div class='col text-center bg-secondary text-white px-1' data-toggle="tooltip" data-placement="top" title="@date($event->end_repeat)">
                                        <strong>
                                            @day($event->end_repeat)<br class="d-none d-lg-block"/>
                                            @month($event->end_repeat)
                                        </strong>
                                    </div>
                                @endif
                                </div>
                            </div>
                            <div class="col-md-3 py-3 py-md-0 vcenter title">
                                {{--<a href="{{ route('events.show',$event->id) }}">{{ $event->title }}</a>--}}
                                <a href="/event/{{$event->slug}}/{{$event->rp_id}}">
                            {{--    {!! route('events.show', ['id'=>$event->id, 'rp_id'=>$event->rp_id])  !!}">--}}
                                    {{ str_limit($event->title, $limit = 50, $end = '...') }}
                                </a>
                            </div>
                            <div class="col-md-3 vcenter teachers">
                                @if(!empty($event->sc_teachers_names))
                                <i data-toggle="tooltip" data-placement="top" title="Teachers" class="far fa-users mr-2"></i>
                                <div class="names">
                                    {{ $event->sc_teachers_names }}
                                </div>
                                @endif
                            </div>
                            <div class="col-md-2 vcenter category mt-2 mt-md-0">
                                <i data-toggle="tooltip" data-placement="top" title="Category" class="fa fa-tag mr-2"></i>
                                {{ $eventCategories[$event->category_id] }}
                            </div>
                            <div class="col-md-4 col-lg-3 vcenter location mt-2 mt-md-0">
                                <i data-toggle="tooltip" data-placement="top" title="Venue" class="far fa-map-marker-alt mr-2" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;"></i>
                                <div class="details">
                                    {{ $event->sc_venue_name }}<br />
                                    {{ $event->sc_city_name }},
                                    {{ $event->sc_country_name }}
                                </div>
                            </div>
                            {{--<div class="col-md-1 vcenter facebook mt-2 mt-md-0">
                                @if(!empty($event->facebook_event_link))
                                    <a href='{{ $event->facebook_event_link }}' target='_blank'><i class='fab fa-facebook-square' data-toggle="tooltip" data-placement="top" title="Facebook event"></i></a>
                                @endif
                            </div>--}}
                        </div>
                    @endforeach
                </div>

                {!! $events->links() !!}
            @endif   
        </div>
        <div class="bg-overlay"></div>


    </div>

@endsection

{{--
@section('content')

@endsection
--}}
