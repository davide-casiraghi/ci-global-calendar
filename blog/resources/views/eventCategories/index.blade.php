@extends('eventCategories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.events_category_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('eventCategories.create') }}">@lang('views.create_new_category')</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif


    {{-- List of categories --}}
    <div class="venuesList my-4">
        @foreach ($eventCategories as $eventCategory)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-md-6 col-lg-8 py-3 title">
                    <a href="{{ route('eventCategories.edit',$eventCategory->id) }}">{{ $eventCategory->name }}</a>
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('eventCategories.destroy',$eventCategory->id) }}" method="POST">

                        {{--<a class="btn btn-info mr-2" href="{{ route('eventCategories.show',$eventCategory->id) }}">@lang('views.view')</a>--}}
                        <a class="btn btn-primary" href="{{ route('eventCategories.edit',$eventCategory->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
            </div>
        @endforeach    
    </div>

    {{-- List of categories --}}
    {{--<table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th width="280">Action</th>
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
    </table>--}}


    {!! $eventCategories->links() !!}


@endsection
