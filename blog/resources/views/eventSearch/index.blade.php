{{-- @extends('layouts.app') --}}
@extends('layouts.hpEventSearch')

@section('javascript-document-ready')
    @parent

    {{-- Clear filters on click reset button --}}
    $("#resetButton").click(function(){
        $("input#keywords").val("");
        $('#category option').prop("selected", false).trigger('change');
        $('#teacher option').prop("selected", false).trigger('change');
        $('#country option').prop("selected", false).trigger('change');
        $('#continent option').prop("selected", false).trigger('change');
        $('form#searchForm').submit();
    });

    {{-- BACKGROUND IMAGES --}}


@stop

@section('beforeContent')
    <div class="contactEvents jumbotron">
        @include('partials.jumboBackgroundChange')
        <div class="container">
            <div class="row intro">
                <div class="col-lg-12 text-center">
                    <h1 class="text-white mb-3">Contact Improvisation</h1>
                    <h4 class="text-uppercase"><strong>- Global calendar -</strong></h4>
                    <p class="subtitle text-white">
                        Find information about Contact Improvisation events worldwide (classes, jams, workshops, festivals and more)<br>WE ARE UNDER CONSTRUCTION, calendar is still in beta testing phase, we plan to fully operate starting from January 2019 on
                    </p>
                    <p class="searchHere text-white mt-5">
                        Search here with one criteria or more
                    </p>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-4">
                    <p>{{ $message }}</p>
                </div>
            @endif

            {{-- Search form --}}
            <form id="searchForm" action="{{ route('eventSearch.index') }}" method="GET">
                @csrf

                {{--<div class="row mt-3">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by event name" value="{{ $searchKeywords }}">
                    </div>
                </div>--}}

                <div class="row">
                    <div class="col-md-4">
                        <p><strong class="text-white">What</strong></p>
                        @include('partials.forms.event-search.select-category')

                        <p class="mt-3"><strong class="text-white">Who</strong></p>
                        @include('partials.forms.event-search.select-teacher')
                    </div>
                    <div class="col-md-4">
                        <p><strong class="text-white">Where</strong></p>
                        @include('partials.forms.event-search.select-continent')
                        @include('partials.forms.event-search.select-country')
                        <p class="mt-3"><strong class="text-white">Search by name of venue only</strong></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong class="text-white">When</strong></p>
                        @include('partials.forms.event-search.input-date-start')
                        @include('partials.forms.event-search.input-date-end')
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-sm-10 mt-3">
                        <a id="resetButton" class="btn btn-info float-right ml-2" href="#">Reset</a>
                        <input type="submit" value="Search" class="btn btn-primary float-right">
                    </div>
                </div>
            </form>

            {{-- List of events --}}
            {{--<table class="table table-bordered mt-4">
                <tr>
                    <th>Title</th>
                    <th>Teachers</th>
                    <th>Category</th>
                    <th>Venue</th>
                </tr>
                @foreach ($events as $event)
                <tr>
                    <td><a href="{{ route('eventSearch.show',$event->id) }}">{{ $event->title }}</a></td>
                    <td>{{ $event->sc_teachers_names }}</td>
                    <td>{{ $eventCategories[$event->category_id] }}</td>
                    <td>
                        {{ $event->sc_venue_name }}<br />
                        {{ $event->sc_city_name }},
                        {{ $event->sc_country_name }}
                    </td>
                </tr>
                @endforeach
            </table>
        --}}



            <div class="eventList mt-5">
                @foreach ($events as $event)
                    <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                        <div class="col-lg-1 date">
                            <div class="row text-uppercase">

                            {{-- One day event --}}
                            @if (@date($event->start_repeat)==@date($event->end_repeat))
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
                            <a href="{!! route('events.show', ['id'=>$event->id, 'rp_id'=>$event->rp_id])  !!}">{{ $event->title }}</a>
                        </div>
                        <div class="col-md-3 vcenter teachers">
                            @if(!empty($event->sc_teachers_names))
                            <i data-toggle="tooltip" data-placement="top" title="Teachers" class="far fa-users mr-2"></i>
                            {{ $event->sc_teachers_names }}
                            @endif
                        </div>
                        <div class="col-md-2 vcenter category mt-2 mt-md-0">
                            <i data-toggle="tooltip" data-placement="top" title="Category" class="fa fa-tag mr-2"></i>
                            {{ $eventCategories[$event->category_id] }}
                        </div>
                        <div class="col-md-3 vcenter location mt-2 mt-md-0">
                            <i data-toggle="tooltip" data-placement="top" title="Venue" class="far fa-map-marker-alt mr-2" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;"></i>
                            {{ $event->sc_venue_name }}<br />
                            {{ $event->sc_city_name }},
                            {{ $event->sc_country_name }}
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

        </div>
        <div class="bg-overlay"></div>


    </div>

@endsection

{{--
@section('content')

@endsection
--}}
