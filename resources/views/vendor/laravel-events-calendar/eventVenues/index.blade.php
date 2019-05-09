@extends('laravel-events-calendar::eventVenues.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@stop

@section('content')
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h4>@lang('views.events_venue_management')</h4>
            </div>
            <div class="col-12 col-sm-5 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('eventVenues.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_venue')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif


        {{-- Search form --}}
        <form class="searchForm mt-3" action="{{ route('eventVenues.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-12 col-sm-6 pr-sm-2">
                    @include('laravel-events-calendar::partials.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_venue_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-6">
                    @include('laravel-events-calendar::partials.select', [
                        'name' => 'country_id',
                        'placeholder' => __('views.filter_by_country'),
                        'records' => $countries,
                        'seleted' => $searchCountry,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                    ])
                </div>
                <div class="col-12">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2" style="white-space: normal;">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>

        {{-- List of venues --}}
        <div class="venuesList my-4">
            @foreach ($eventVenues as $eventVenue)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    <div class="col-12 py-1 title">
                        <h5 class="darkest-gray">{{ $eventVenue->name }}</h5>
                    </div>
                    <div class="col-12 mb-4">
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                        @if($eventVenue->country_id){{ $countries[$eventVenue->country_id] }}@endif
                            
                        <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-city mr-1 ml-4 dark-gray" data-original-title="@lang('general.city')"></i>
                        {{$eventVenue->city}}
                    </div>
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('eventVenues.destroy',$eventVenue->id) }}" method="POST">

                            <a class="btn btn-primary float-right" href="{{ route('eventVenues.edit',$eventVenue->id) }}">@lang('views.edit')</a>
                            <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('eventVenues.show',$eventVenue->id) }}">@lang('views.view')</a>
                            
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                        </form>
                    </div>
                </div>    
                {{--
                <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                    <div class="col-12 col-md-6 col-lg-8 py-3 title">
                        <a href="{{ route('eventVenues.edit',$eventVenue->id) }}">{{ $eventVenue->name }}</a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 pb-3 py-md-3 country">
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-2" data-original-title="@lang('general.country')"></i>
                        {{ $countries[$eventVenue->country_id] }}
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 pb-3 py-md-3 city">
                        <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-city mr-2" data-original-title="@lang('general.city')"></i>
                        {{$eventVenue->city}}
                    </div>
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('eventVenues.destroy',$eventVenue->id) }}" method="POST">

                            <a class="btn btn-info mr-2" href="{{ route('eventVenues.show',$eventVenue->id) }}">@lang('views.view')</a>
                            <a class="btn btn-primary" href="{{ route('eventVenues.edit',$eventVenue->id) }}">@lang('views.edit')</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                        </form>
                    </div>
                </div>
                --}}
            @endforeach    
        </div>
        
        {!! $eventVenues->appends([
            'keywords' => $searchKeywords,
            'country_id' => $searchCountry,
        ])->links() !!}

    </div>

@endsection
