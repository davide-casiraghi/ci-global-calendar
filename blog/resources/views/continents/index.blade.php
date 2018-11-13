@extends('continents.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Continent management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('continents.create') }}"> Create New Continent</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th width="140">Code</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($continents as $continent)
        <tr>
            <td>{{ $continent->id }}</td>
            <td>{{ $continent->name }}</td>
            <td>{{ $continent->code }}</td>
            <td>
                <form action="{{ route('continents.destroy',$continent->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('continents.show',$continent->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('continents.edit',$continent->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $continents->links() !!}


@endsection
