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
    
    {{-- Update Continent SELECT on change Country SELECT --}}
        $("select[name='country_id']").on('change', function() {

            var request = $.ajax({
                url: "/update_continents_dropdown",
                data: {
                    country_id: this.value,
                },
                success: function( data ) {
                    $("#continent_id").selectpicker('val', data);
                }
            });
        });

    {{-- Update Country SELECT on change Continent SELECT --}}
        $("select[name='continent_id']").on('change', function() {
            updateCountriesDropdown(this.value);
            updateRegionsDropdown('');  // clear the region dropdown
        });
        
    {{-- Update Region SELECT on change Country SELECT --}}
        $("select[name='country_id']").on('change', function() {
            if (this.value != ''){
                updateRegionsDropdown(this.value);
            }
        });
        
        $(document).ready(function(){
            
            {{-- On page load update 
                    - the Country SELECT if a Continent is selected
                    - the Region SELECT if a Country is selected
             --}}
                setTimeout(function(){
                    var continent_id =  $("select[name='continent_id']").val();
                    var country_id =  $("select[name='country_id']").val();
                    var region_id =  $("select[name='region_id']").val();
                     
                    if (continent_id != ''){
                        updateCountriesDropdown(continent_id);
                        if (country_id != null){
                            setTimeout(() => {
                                $("#country_id").selectpicker('val', country_id);
                            }, 300);
                         }
                     }
                     
                     if (country_id != ''){
                         updateRegionsDropdown(country_id);
                         if (region_id != null){
                             setTimeout(() => {
                                 $("#region_id").selectpicker('val', region_id);
                             }, 300);
                          }
                      }
                     
                }, 3000);
                
                
		});
        
        {{-- Update the Countries SELECT with just the ones 
             relative to the selected continent --}}
        function updateCountriesDropdown(selectedContinent){
            var request = $.ajax({
                url: "/update_countries_dropdown",
                data: {
                    continent_id: selectedContinent,
                },
                success: function( data ) {
                    $("#country_id").html(data);
                    $("#country_id").selectpicker('refresh');
                }
            });
        }
        
        {{-- Update the Regions SELECT with just the ones 
             relative to the selected country --}}
        function updateRegionsDropdown(selectedCountry){
            var request = $.ajax({
                url: "/update_regions_dropdown",
                data: {
                    country_id: selectedCountry,
                },
                success: function( data ) {
                    $("#region_id").html(data);
                    $("#region_id").selectpicker('refresh');
                }
            });
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

    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('partials.hilight', [
                    /*'title' =>  'Dear users: ',
                    'text' =>  'The CI Global Calendar is a non-profit project to support the CI Global Community. 
                                To protect our independence we don’t want to run ads. We have no governmental funds. 
                                If the calendar is useful to you take one minute to help us keep it online another year. If everyone reading this message would give the same amount that you offer for a jam, our fundraiser would be done within a week. Thank you!',*/
                     /* 'title' =>  'Dear users of CI Global Calendar,',
                      'text' =>  '
                      <br>
                      Nancy Stark Smith passed away last Friday 1 May, and it is with deep grief that we join ourselves to sending our love and thankfulness in remembrance of her life. <br>
                        Nancy was a driving force in bringing movers together, in the development of Contact Improvisation and in the invention of ways for dancers to tell their stories and experiences. With Contact Quarterly, the Underscore and many more practices of improvising, teaching, dancing, collecting words and traces of collective experiences, Nancy was a node-maker, a community-herder and an innovator. <br>
                        The Round Robin Project, the Contact Improvisation Global Calendar and the Contact Improvisation Global An/Archive are traces of her constant effort to make kins and alliances and friendships and resources. As in all her other endeavors, she put love, artistry and dedication in those projects, and we feel blessed to have worked along her sides and to have learnt so much from her.<br><br>
                        Always remembering with love, <br>
                         
                        The former and current Round Robin Project Steering Commitee <br>

                        The CI Global (An)Archive Team <br>

                        The CI Global Calendar Team <br>


                        PS: you can also visit the ',*/
                   /* 'title' =>  'Online Events in the CI Global Calendar',
                    'text' =>  '<br>
                    A new feature that allows you to post and to search for online events is now available.<br>
                    To <b>search for an online event</b> in a given language, on the home page, from the list of CONTINENTS select “Online”; Then as COUNTRY, select the language that you wish to follow the class or event into, e.g. “Online English”; Then click SEARCH. All the results for English online events will be displayed.<br>

                    To <b>post an online event, </b>use the page for event creation as usual. As VENUE select the option that reflects the language that will be used for your event. E.g. “Online English” to post an English online event.<br>
                    In case the language you want to use for your online event is not available in the venue list, please ',
                        
                      //'linkText' => 'Donate',
                      //'linkUrl'  => '/post/donate',
                      'linkText' => 'ask to the webmaster to add it.',
                      'linkUrl'  => 'http://ci-global-calendar.test/contactForm/compose/webmaster',
                */

                'title' =>  'A new project by CIGlobal Calendar! ',
                      'text' =>  '
                      <br>
                      CI Bodies Dairy! a virtual space where to share, celebrate and document our relation and love for CI. <br><br>
                      What CI is for you? <br>
                      What CI brings/brought to your life?<br><br>

                      Send us a little text or just a picture that is sharing your feeling/belonging/relation with/understanding of with CI.<br>
                      We will collect all the thoughts and pics creating a Global CI BodiesDiary! <br><br>

                      bodydiary@ciglobalcalendar.net
                    ',
                    'linkText' => '',
                      'linkUrl'  => '',
                   ])
            </div>
        </div>
    </div>

    


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
                        {{--@lang('homepage-serach.under_costruction')--}}
                    </p>
                    <p>
                    
                    
                    {{--@include('partials.forms.button', [
                          'text' =>  'Help us with the Global Fill-in',
                          'name' => 'category_id',
                          'url' => '/post/help-us-with-the-global-fill-in',
                          'roundedCorners' => 'true',
                    ])--}}
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
                    <div class="col-md-4 order-2 order-sm-1">
                        
                        {{-- WHAT --}}
                            <p><strong class="text-white">@lang('homepage-serach.what')</strong></p>
                            
                            @include('laravel-form-partials::select', [
                                  'title' =>  '',
                                  'name' => 'category_id',
                                  'placeholder' => __('homepage-serach.all_kind_of_events'),
                                  'records' => $eventCategories,
                                  'selected' => $searchCategory,
                                  'liveSearch' => 'true',
                                  'mobileNativeMenu' => false,  //disabled for the bug on iPad and iPhone - Retry when will be available v.2 of bootstrap-select - https://github.com/snapappointments/bootstrap-select/issues/2228
                            ])
                        
                        {{-- WHO --}}
                            <p class="mt-3"><strong class="text-white">@lang('homepage-serach.who')</strong></p>
                            
                            @include('partials.forms.event-search.select-teacher')
                            
                    </div>
                    <div class="col-md-4 order-1 order-sm-2">
                        <p class="text-white">
                            <strong>@lang('homepage-serach.where')</strong>
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="@lang('homepage-serach.where_tooltip')"></i>
                        </p>
                        
                        
                        {{--
                        <continents-countries-selects select_a_continent_placeholder="@lang('homepage-serach.select_a_continent')" select_a_country_placeholder="@lang('homepage-serach.select_a_country')" continent-selected="{{$searchContinent}}" country-selected="{{$searchCountry}}"></continents-countries-selects>
                        --}}
                        
                        
                        @include('laravel-form-partials::select', [
                              'title' =>  '',
                              'name' => 'continent_id',
                              'placeholder' => __('homepage-serach.select_a_continent'),
                              'records' => $continents,
                              'selected' => $searchContinent,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => false, // disabled for the bug on iPad and iPhone - Retry when will be available v.2 of bootstrap-select - https://github.com/snapappointments/bootstrap-select/issues/2228
                        ])
                        
                        @include('laravel-form-partials::select', [
                              'title' =>  '',
                              'name' => 'country_id',
                              'placeholder' => __('homepage-serach.select_a_country'),
                              'records' => $countries,
                              'selected' => $searchCountry,
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                        ])
                        
                        @include('laravel-form-partials::select', [
                              'title' =>  '',
                              'name' => 'region_id',
                              'placeholder' => __('homepage-serach.select_a_region'),
                              'records' => $regions,
                              'selected' => $searchRegion,
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                        ])
                        
                        @include('laravel-form-partials::input', [
                              'title' => '',
                              'name' => 'city_name',
                              'placeholder' => __('homepage-serach.search_by_city'),
                              'value' => $searchCity
                        ])
                        
                        {{--<p class="mt-3"><strong class="text-white">@lang('homepage-serach.search_by_venue')</strong></p>--}}
                        @include('laravel-form-partials::input', [
                              'title' => '',
                              'name' => 'venue_name',
                              'placeholder' => __('homepage-serach.venue_name'),
                              'value' => $searchVenue
                        ])
                    </div>
                    <div class="col-md-4 order-3">
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
                
                {{-- Photo Credits--}}
                <div class="row">
                    <small class="col-12 credits mt-5">
                        @lang('homepage-serach.photo_credits'):
                        <span class="name">
                            
                        </span>
                    </small>
                </div>
                    
                
            </form>

            @if (Route::is('eventSearch.index'))  {{-- Show search results just when search button is pressed --}}
                
                {{-- List of events --}}
                <a id="dataarea"></a> {{-- Anchor to scroll on search --}}
                <div class="row mt-5">
                    <div class="col-7 col-md-9"></div>
                    <div class="col-5 col-md-3 bg-light text-right py-1">
                        <small>{{$events->total()}} @lang('homepage-serach.results_found')</small>
                    </div>
                </div>
                
                @include('partials.event-list', [
                      'events' => $events,
                      'iframeLinkBlank' => false,
                ])

                {{--{!! $events->links() !!}--}}
                
                {!! $events->appends([
                    'category_id' => $searchCategory,
                    'continent_id' => $searchContinent,
                    'country_id' => $searchCountry,
                    'region_id' => $searchRegion,
                    'city_name' => $searchCity,
                    'venue_name' => $searchVenue,
                    'startDate' => $searchStartDate,
                    'endDate' => $searchEndDate,
                ])->links() !!}
                
                
            @endif   
        </div>
        <div class="bg-overlay"></div>


    </div>

@endsection

{{--
@section('content')

@endsection
--}}
