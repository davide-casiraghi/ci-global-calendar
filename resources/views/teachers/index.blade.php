@extends('teachers.layout')

@section('javascript-document-ready')
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if(Route::current()->getName() == 'teachers.index') 
                <h2>@lang('views.teachers_management')</h2>
            @elseif(Route::current()->getName() == 'teachers.directory') 
                <h2>@lang('views.teachers_directory')</h2>
            @endif
        </div>
        
        @if(Route::current()->getName() == 'teachers.index') 
            <div class="col-12 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('teachers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_teacher')</a>
            </div>
        @endif
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row searchForm mt-3" action="@if(Route::current()->getName() == 'teachers.index') {{ route('teachers.index') }} @else {{ route('teachers.directory') }} @endif" method="GET">
        @csrf
        <div class="col-12 col-sm-6 col-md-6 col-lg-5">
            @include('partials.forms.input', [
                'name' => 'keywords',
                'placeholder' => __('views.search_by_teacher_name'),
                'value' => $searchKeywords
            ])
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
            @include('partials.forms.select', [
                'name' => 'country_id',
                'placeholder' => __('views.filter_by_country'),
                'records' => $countries,
                'seleted' => $searchCountry,
                'liveSearch' => 'true',
                'mobileNativeMenu' => 'false',
            ])
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
                <div class="col-12 col-md-6 col-lg-7 py-3 title">
                    <a href="/teacher/{{ $teacher->slug }}">{{ $teacher->name }}</a>
                </div>
                <div class="col-12 col-md-6 col-lg-3 pb-3 py-md-3 country">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-2" data-original-title="@lang('general.country')"></i>
                    @if($teacher->country_id){{ $countries[$teacher->country_id] }}@endif
                </div>

                {{-- Show the edit and delete console just to the owner or the administrators --}}
                {{--@if($teacher->created_by == $loggedUser->id || $loggedUser->group == 1 || $loggedUser->group == 2) --}}
                @if(Route::current()->getName() == 'teachers.index') 
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('teachers.destroy',$teacher->id) }}" method="POST">

                            <a class="btn btn-info mr-2" href="{{ route('teachers.show',$teacher->id) }}">@lang('views.view')</a>
                            <a class="btn btn-primary" href="{{ route('teachers.edit',$teacher->id) }}">@lang('views.edit')</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                        </form>
                    </div>
                @endif
                {{--@endif--}}
                
                
            </div>
        @endforeach 
    </div>


    {!! $teachers->links() !!}


@endsection
