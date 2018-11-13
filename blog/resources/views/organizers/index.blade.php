@extends('organizers.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Organizers management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('organizers.create') }}"> Create New Organizer</a>
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
            <th width="280">Action</th>
        </tr>
        @foreach ($organizers as $organizer)
        <tr>
            <td>{{ $organizer->id }}</td>
            <td>{{ $organizer->name }}</td>
            <td>
                <form action="{{ route('organizers.destroy',$organizer->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('organizers.show',$organizer->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('organizers.edit',$organizer->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $organizers->links() !!}


@endsection
