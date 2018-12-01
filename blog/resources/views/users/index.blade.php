@extends('users.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row mt-3" action="{{ route('users.index') }}" method="GET">
        @csrf
        <div class="form-group col-lg-7 col-md-6 col-sm-6 col-xs-4">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by user name" value="{{ $searchKeywords }}">
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
        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-4 mt-sm-0 mt-3">
            <input type="submit" value="Search" class="btn btn-primary float-sm-right">
        </div>
    </form>


    {{-- List of teachers --}}
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Country</th>
            <th width="100">Status</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>@if(!empty($user->country_id)){{ $countries[$user->country_id] }}@endif</td>
            <td class="text-center align-middle">@if(!empty($user->status)){!! '<i class="fas fa-dot-circle" style="color:green;"></i>' !!}@else{!!'<i class="fas fa-dot-circle" style="color:red;"></i>'!!}@endif</td>
            <td>
                <form action="{{ route('users.destroy',$user->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $users->links() !!}


@endsection
