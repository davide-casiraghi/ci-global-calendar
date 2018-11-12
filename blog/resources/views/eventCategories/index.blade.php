@extends('eventCategories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Event categories management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('eventCategories.create') }}"> Create New Category</a>
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
            <th width="280px">Action</th>
        </tr>
        @foreach ($eventCategories as $eventCategory)
        <tr>
            <td>{{ $eventCategory->id }}</td>
            <td>{{ $eventCategory->name }}</td>
            <td>
                <form action="{{ route('eventCategories.destroy',$eventCategory->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('eventCategories.show',$eventCategory->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('eventCategories.edit',$eventCategory->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $eventCategories->links() !!}


@endsection
