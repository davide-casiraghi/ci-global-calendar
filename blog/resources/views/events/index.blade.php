@extends('events.layout')

@section('javascript-document-ready')
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input#keywords").val("");
            $('#category option').prop("selected", false).trigger('change');
            $('#country option').prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Events Management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('events.create') }}"> Create New event</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row mt-3 searchForm" action="{{ route('events.index') }}" method="GET">
        @csrf
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by event name" value="{{ $searchKeywords }}">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <select name="category_id" id="category" class="selectpicker" data-live-search="true" title="Search by category">
                @foreach ($eventCategories as $value => $eventCategory)
                    {{-- {{ $event->category_id == $value ? 'selected' : '' }} --}}
                    <option value="{{$value}}" {{ $searchCategory == $value ? 'selected' : '' }} >{!! $eventCategory !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-sm-0 mt-3">
            <select name="country_id" id="country" class="selectpicker" data-live-search="true" title="Search by country">
                @foreach ($countries as $value => $country)
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 mt-sm-0 mt-3">
            <a id="resetButton" class="btn btn-info" href="#">Reset</a>
            <input type="submit" value="Search" class="btn btn-primary">
        </div>
    </form>

    {{-- List of events --}}
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Country</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td>{{ $event->title }}</td>
            <td>{{ $eventCategories[$event->category_id] }}</td>
            <td>
                {{ $countries[$venues[$event->venue_id]] }}
            </td>
            <td>
                <form action="{{ route('events.destroy',$event->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('events.show',$event->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('events.edit',$event->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $events->links() !!}


@endsection
