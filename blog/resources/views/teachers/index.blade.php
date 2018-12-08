@extends('teachers.layout')


@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.teachers_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success" href="{{ route('teachers.create') }}">@lang('views.create_new_teacher')</a>
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
        <div class="form-group col-12 col-sm-6 col-md-6 col-lg-5">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="@lang('views.search_by_teacher_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
            <select name="country_id" class="selectpicker" data-live-search="true">
                <option value="">@lang('views.filter_by_country')</option>
                @foreach ($countries as $value => $country)
                    {{-- {{ $event->category_id == $value ? 'selected' : '' }} --}}
                    <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-lg-3 mt-3 mt-sm-0">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>

    {{-- List of teachers --}}
    <div class="teachersList my-4">
        @foreach ($teachers as $teacher)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-md-6 col-lg-7 py-2 title">
                    <a href="{{ route('teachers.edit',$teacher->id) }}">{{ $teacher->name }}</a>
                </div>
                <div class="col-12 col-md-6 col-lg-3 pb-2 py-md-2 country">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-2" data-original-title="@lang('general.country')"></i>
                    @if($teacher->country_id){{ $countries[$teacher->country_id] }}@endif
                </div>
                <div class="col-12 pb-2 action">
                    <form action="{{ route('teachers.destroy',$teacher->id) }}" method="POST">

                        <a class="btn btn-info mr-2" href="{{ route('teachers.show',$teacher->id) }}">@lang('views.view')</a>
                        <a class="btn btn-primary" href="{{ route('teachers.edit',$teacher->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
                
                
            </div>
        @endforeach 
    </div>


    {!! $teachers->links() !!}


@endsection
