@extends('users.layout')

@section('javascript-document-ready')
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input#keywords").val("");
            $('#country option').prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@endsection

@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.users_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('users.create') }}">@lang('views.add_new_user')</a>
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
        <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="@lang('views.search_by_user_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <select name="country_id" class="selectpicker" data-live-search="true">
                <option value="">@lang('views.filter_by_country')</option>
                @foreach ($countries as $value => $country)
                    {{-- {{ $event->category_id == $value ? 'selected' : '' }} --}}
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-3 mt-3 mt-sm-2 mt-lg-0">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>

    {{-- List of users --}}
    <div class="usersList my-4">
        @foreach ($users as $user)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-sm-5 py-3 name">
                    <a href="{{ route('users.edit',$user->id) }}">{{ $user->name }}</a>
                </div>
                <div class="col-6 col-sm-4 py-3 country">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-2" data-original-title="@lang('general.country')"></i>
                    @if(!empty($user->country_id)){{ $countries[$user->country_id] }}@endif
                </div>
                <div class="col-6 col-sm-3 py-3 status text-right">
                    @if(!empty($user->status)){!! '<span class="badge badge-success">Enabled</span>' !!}@else{!!'<span class="badge badge-danger">Disabled</span>'!!}@endif
                </div>
                <div class="col-12 pb-2 action">
                    <form action="{{ route('users.destroy',$user->id) }}" method="POST">

                        <a class="btn btn-info mr-2" href="{{ route('users.show',$user->id) }}">@lang('views.view')</a>
                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
            </div>
        @endforeach 
    </div>
    {{-- List of users --}}
    {{--<table class="table table-bordered mt-4">
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
    </table>--}}


    {!! $users->links() !!}


@endsection
