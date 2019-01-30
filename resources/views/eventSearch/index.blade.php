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
        
        

    {{-- HI-Light for the donations --}}
    @include('partials.hilight', [
          'title' =>  'Dear Global Calendar users: ',
          'text' =>  'We are the small non-profit that runs the #5 website in the world. We have only 150 staff but serve 450 million users, and have costs like any other top site: servers, power, rent, programs, and staff. Wikipedia is something special. It is like a library or a public park. It is like a temple for the mind, a place we can all go to think and learn. To protect our independence, we’ll never run ads. We take no government funds. We run on donations averaging about $30. If everyone reading this gave $3, our fundraiser would be done within an hour. If Wikipedia is useful to you, take one minute to keep it online another year. Please help us forget fundraising and get back to Wikipedia. Thank you.',
          'backgroundColor' => 'gray',
          'textColor' => 'white',
          'linkText' => 'Donate',
          'linkUrl'  => '/post/donate',
    ])
    


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
                                  'liveSearch' => 'false',
                                  'mobileNativeMenu' => true,
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
                        
                        @include('partials.forms.select', [
                              'title' =>  '',
                              'name' => 'continent_id',
                              'placeholder' => __('homepage-serach.select_a_continent'),
                              'records' => $continents,
                              'seleted' => $searchContinent,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                        ])
                        
                        @include('partials.forms.select', [
                              'title' =>  '',
                              'name' => 'country_id',
                              'placeholder' => __('homepage-serach.select_a_country'),
                              'records' => $countries,
                              'seleted' => $searchCountry,
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                        ])
                        
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
                
                @include('partials.event-list', [
                      'events' => $events,
                      'iframeLinkBlank' => false,
                ])

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
