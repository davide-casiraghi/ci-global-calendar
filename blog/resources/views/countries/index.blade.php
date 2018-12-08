@extends('countries.layout')


@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.countries_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success" href="{{ route('countries.create') }}">@lang('views.create_new_country')</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form class="row mt-3" action="{{ route('countries.index') }}" method="GET">
        @csrf
        <div class="form-group col-8 col-sm-10 col-md-10 col-lg-10">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="@lang('views.search_by_country_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-4 col-sm-2 col-md-2 col-lg-2">
            <input type="submit" value="Search" class="btn btn-primary float-sm-right">
        </div>
    </form>

    <table class="table table-bordered mt-2">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th width="140">Code</th>
            <th width="180">Continent</th>
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



    {!! $countries->links() !!}


@endsection
