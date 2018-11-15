@extends('teachers.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Teachers management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('teachers.create') }}"> Create New Teacher</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row mt-3" action="{{ route('teachers.index') }}" method="GET">
        @csrf
        <div class="form-group col-lg-7 col-md-6 col-sm-6 col-xs-4">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by teacher name" value="{{ $searchKeywords }}">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select name="country_id" class="selectpicker" data-live-search="true">
                <option value="">Search by country</option>
                @foreach ($countries as $value => $country)
                    {{-- {{ $event->category_id == $value ? 'selected' : '' }} --}}
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-4">
            <input type="submit" value="Search" class="btn btn-primary float-sm-right">
        </div>
    </form>


    {{-- List of teachers --}}
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Country</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($teachers as $teacher)
        <tr>
            <td>{{ $teacher->id }}</td>
            <td>{{ $teacher->name }}</td>
            <td>{{ $countries[$teacher->country_id] }}</td>
            <td>
                <form action="{{ route('teachers.destroy',$teacher->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('teachers.show',$teacher->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('teachers.edit',$teacher->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $teachers->links() !!}


@endsection
