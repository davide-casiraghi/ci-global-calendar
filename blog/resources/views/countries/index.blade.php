@extends('countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Countries management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('countries.create') }}"> Create New Country</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form class="row mt-3" action="{{ route('countries.index') }}" method="GET">
        @csrf
        <div class="form-group col-lg-11 col-md-10 col-sm-10 col-xs-8">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by country name" value="{{ $searchKeywords }}">
        </div>
        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-4">
            <input type="submit" value="Search" class="btn btn-primary float-sm-right">
        </div>
    </form>

    <table class="table table-bordered mt-2">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th width="140">Code</th>
            <th width="180">Continent ID</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($countries as $country)
        <tr>
            <td>{{ $country->id }}</td>
            <td>{{ $country->name }}</td>
            <td>{{ $country->code }}</td>
            <td>{{ $continents[$country->continent_id] }}</td>
            <td>
                <form action="{{ route('countries.destroy',$country->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('countries.show',$country->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('countries.edit',$country->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {{--{!! $countries->links() !!}--}}


@endsection
