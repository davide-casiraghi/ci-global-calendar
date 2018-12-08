@extends('organizers.layout')

@section('javascript-document-ready')
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $('form.searchForm').submit();
        });
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.organizers_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success" href="{{ route('organizers.create') }}">@lang('views.create_new_organizer')</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row searchForm mt-3" action="{{ route('organizers.index') }}" method="GET">
        @csrf
        <div class="form-group col-12 col-sm-12 col-md-8 col-lg-9 mb-2">
            <input type="text" name="keywords" class="form-control" placeholder="@lang('views.search_by_organizer_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-lg-3 mt-3 mt-md-0">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>


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
