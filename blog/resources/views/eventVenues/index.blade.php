@extends('eventVenues.layout')

@section('javascript-document-ready')
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.events_venue_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success" href="{{ route('eventVenues.create') }}">@lang('views.create_new_venue')</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif


    {{-- Search form --}}
    <form class="row searchForm mt-3" action="{{ route('eventVenues.index') }}" method="GET">
        @csrf
        <div class="form-group col-12 col-md-6 col-lg-5 mb-2">
            <input type="text" name="keywords" class="form-control" placeholder="@lang('views.search_by_venue_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
            <select name="country_id" class="selectpicker" data-live-search="true" title="@lang('views.filter_by_country')">
                @foreach ($countries as $value => $country)
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-lg-3 mt-3 mt-sm-0">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>

    {{-- List of venues --}}
    <div class="venuesList my-4">
        @foreach ($eventVenues as $eventVenue)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-md-6 col-lg-8 py-2 title">
                    <a href="{{ route('eventVenues.edit',$eventVenue->id) }}">{{ $eventVenue->name }}</a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 pb-2 py-md-2 country">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-2" data-original-title="@lang('general.country')"></i>
                    {{ $countries[$eventVenue->country_id] }}
                </div>
                <div class="col-6 col-md-3 col-lg-2 pb-2 py-md-2 city">
                    <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-city mr-2" data-original-title="@lang('general.city')"></i>
                    aaaa
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
        @endforeach    
    </div>


    {!! $eventVenues->links() !!}


@endsection
