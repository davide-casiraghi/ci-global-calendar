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
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Event venues management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('eventVenues.create') }}"> Create New Venue</a>
            </div>
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
        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-5 mb-2">
            <input type="text" name="keywords" class="form-control" placeholder="Search by venue name" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-2">
            <select name="country_id" class="selectpicker" data-live-search="true">
                <option value="">Search by country</option>
                @foreach ($countries as $value => $country)
                    {{-- {{ $event->category_id == $value ? 'selected' : '' }} --}}
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-3 mt-3 mt-lg-0">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>


    {{-- List of venues --}}
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Country</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($eventVenues as $eventVenue)
        <tr>
            <td>{{ $eventVenue->id }}</td>
            <td>{{ $eventVenue->name }}</td>
            <td>{{ $countries[$eventVenue->country_id] }}</td>
            <td>
                <form action="{{ route('eventVenues.destroy',$eventVenue->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('eventVenues.show',$eventVenue->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('eventVenues.edit',$eventVenue->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $eventVenues->links() !!}


@endsection
