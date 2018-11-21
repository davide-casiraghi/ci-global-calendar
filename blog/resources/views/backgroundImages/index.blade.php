@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Background Images management</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('backgroundImages.create') }}"> Add new background image</a>
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
            <th>Title</th>
            <th>Credits</th>
            <th>Image</th>
            <th width="230">Action</th>
        </tr>
        @foreach ($backgroundImages as $backgroundImage)
        <tr>
            <td>{{ $backgroundImage->title }}</td>
            <td>{{ $backgroundImage->credits }}</td>
            <td><img src="@if(!empty($backgroundImage->folder)) {{ $backgroundImage->folder }} @endif/{{ $backgroundImage->image_src }}" width="150" class="mx-auto d-block"></td>
            <td>
                <form action="{{ route('backgroundImages.destroy',$backgroundImage->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('backgroundImages.show',$backgroundImage->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('backgroundImages.edit',$backgroundImage->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $backgroundImages->links() !!}

@endsection
