@extends('laravel-events-calendar::teachers.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@stop

@section('content')
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                @if(Route::current()->getName() == 'teachers.index') 
                    <h3>@lang('views.teachers_management')</h3>
                @elseif(Route::current()->getName() == 'teachers.directory') 
                    <h3>@lang('views.teachers_directory')</h3>
                @endif
            </div>
            
            @if(Route::current()->getName() == 'teachers.index') 
                <div class="col-12 col-sm-5 mt-4 mt-sm-0 text-right">
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
        <form class="searchForm mt-3" action="@if(Route::current()->getName() == 'teachers.index') {{ route('teachers.index') }} @else {{ route('teachers.directory') }} @endif" method="GET">
            @csrf
            <div class="row">
                <div class="col-12 col-sm-6 pr-sm-2">
                    @include('laravel-events-calendar::partials.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_teacher_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-6">
                    @include('laravel-events-calendar::partials.select', [
                        'name' => 'country_id',
                        'placeholder' => __('views.filter_by_country'),
                        'records' => $countries,
                        'seleted' => $searchCountry,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                    ])
                </div>
                <div class="col-12">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>

        {{-- List of teachers --}}
        <div class="teachersList my-4">
            @foreach ($teachers as $teacher)
                <div class="row bg-white shadow-1 rounded mb-3 mx-1">
                    
                    <div class="d-none d-sm-block col-sm-4 p-0">
                        @if(!empty($teacher->profile_picture))
                            <img class="rounded-left" style="width:100%; height:100%;" alt="{{ $teacher->name }}" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}">
                        @else
                            <span class="gray-bg rounded-left d-block" style="width:100%; height:100%;"></span>
                        @endif
                    </div>
                    
                    <div class="col-12 col-sm-8 pb-2 pt-3 px-3">
                        <div class="row">
                            <div class="col-12 py-1 title">
                                <h5 class="darkest-gray">{{ $teacher->name }}</h5>
                            </div>
                            <div class="col-12 mb-4">
                                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                                @if((count($countries) > 0)&&$teacher->country_id){{ $countries[$teacher->country_id] }}@endif
                            </div>
                            {{-- Teachers index - Manager --}}
                            @if(Route::current()->getName() == 'teachers.index') 
                                <div class="col-12 pb-2 action">
                                    <form action="{{ route('teachers.destroy',$teacher->id) }}" method="POST">

                                        <a class="btn btn-primary float-right" href="{{ route('teachers.edit',$teacher->id) }}">@lang('views.edit')</a>
                                        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('teachers.show',$teacher->id) }}">@lang('views.view')</a>
                                        
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                                    </form>
                                </div>
                            {{-- Teachers directory  --}}
                            @else
                                <div class="col-12 pb-2 action">
                                    <a class="btn btn-primary float-right" href="{{ route('teachers.show',$teacher->id) }}">@lang('views.view')</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
                
            @endforeach 
        </div>
        
        {!! $teachers->appends([
            'country_id' => $searchCountry,
            'keywords' => $searchKeywords,
        ])->links() !!}
    </div>

@endsection
