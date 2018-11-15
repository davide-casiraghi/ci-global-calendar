@extends('eventSearch.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Event search interface </h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    {{--
    <form class="row mt-3" action="{{ route('events.index') }}" method="GET">
        @csrf
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by event name" value="{{ $searchKeywords }}">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <select name="category_id" class="form-control">
                <option value="">Search by category</option>
                @foreach ($eventCategories as $value => $eventCategory)
                    <option value="{{$value}}" {{ $searchCategory == $value ? 'selected' : '' }} >{!! $eventCategory !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-sm-0 mt-3">
            <select name="country_id" class="form-control">
                <option value="">Search by country</option>
                @foreach ($countries as $value => $country)
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 mt-sm-0 mt-3">
            <input type="submit" value="Search" class="btn btn-primary float-sm-right">
        </div>
    </form> --}}

    {{-- List of events --}}
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Country</th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td><a href="{{ route('eventSearch.show',$event->id) }}">{{ $event->title }}</a></td>
            <td>{{ $eventCategories[$event->category_id] }}</td>
            {{--<td>{{ $countries[$event->venue] }}</td>--}}
            {{--<td>{{ $countries[$event->eventVenues] }}</td>--}}
            <td>
                @foreach ($event->eventVenues as $venue)
                    <div>{{ $countries[$venue->country_id] }}</div>
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>


    {!! $events->links() !!}




@endsection
