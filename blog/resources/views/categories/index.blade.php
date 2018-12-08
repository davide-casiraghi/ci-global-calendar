@extends('categories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.category_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('categories.create') }}">@lang('views.create_new_category')</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif


    {{-- List of post categories --}}
    <div class="venuesList my-4">
        @foreach ($categories as $category)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-md-6 col-lg-8 py-3 title">
                    <a href="{{ route('categories.edit',$category->id) }}">{{ $category->name }}</a>
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('categories.destroy',$category->id) }}" method="POST">

                        <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
            </div>
        @endforeach    
    </div>
    {{-- List of post categories --}}
    {{-- <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
                <form action="{{ route('categories.destroy',$category->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('categories.show',$category->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>--}}


    {!! $categories->links() !!}


@endsection
