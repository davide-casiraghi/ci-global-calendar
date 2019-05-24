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
        
        
        @if($teachers->count() > 0) 
            <div class="row">
                <div class="col-12 col-sm-7">
                    @if(Route::current()->getName() == 'teachers.index') 
                        <h3>@lang('laravel-events-calendar::teacher.teachers_management')</h3>
                    @elseif(Route::current()->getName() == 'teachers.directory') 
                        <h3>@lang('laravel-events-calendar::teacher.teachers_directory')</h3>
                    @endif
                </div>
                
                @if(Route::current()->getName() == 'teachers.index') 
                    <div class="col-12 col-sm-5 mt-4 mt-sm-0 text-right">
                        <a class="btn btn-success create-new" href="{{ route('teachers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('laravel-events-calendar::teacher.create_new_teacher')</a>
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
                            'placeholder' => __('laravel-events-calendar::teacher.search_by_teacher_name'),
                            'value' => $searchKeywords
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('laravel-events-calendar::partials.select', [
                            'name' => 'country_id',
                            'placeholder' => __('laravel-events-calendar::general.filter_by_country'),
                            'records' => $countries,
                            'seleted' => $searchCountry,
                            'liveSearch' => 'true',
                            'mobileNativeMenu' => false,
                        ])
                    </div>
                    <div class="col-12">
                        <input type="submit" value="@lang('laravel-events-calendar::general.search')" class="btn btn-primary float-right ml-2">
                        <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('laravel-events-calendar::general.reset')</a>
                    </div>
                </div>
            </form>
        @else    
            {{--  Empty Page --}}
            <div class="wrap empty-page empty-page-teacher min-vh-100">
                <div class="row inner">
                    <div class="col-12 mt-5 max-w-sm">
                        <h3 class="mb-4">Create a teacher profile</h3>
                        
                        <span class="dark-gray">
                            In this page teachers can add their own teacher profile.<br /><br />
                            
                            If you are an organizer and you don’t find the teachers you are organizing for you can add them here.
                            They will be deleted when the teachers will create their own profile.<br />
                        </span>
                    </div>
                    
                    @if(Route::current()->getName() == 'teachers.index') 
                        <div class="col-12">
                            <a class="btn blue-bg-4 create-new white mt-4" href="{{ route('teachers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('laravel-events-calendar::teacher.create_new_teacher')</a>
                        </div>
                    @endif
                </div>
                <div class="inner-background"></div>
            </div>
            
        @endif

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
                                @if($teacher->country_id){{ $countries[$teacher->country_id] }}@endif
                            </div>
                            {{-- Teachers index - Manager --}}
                            @if(Route::current()->getName() == 'teachers.index') 
                                <div class="col-12 pb-2 action">
                                    <form action="{{ route('teachers.destroy',$teacher->id) }}" method="POST">

                                        <a class="btn btn-primary float-right" href="{{ route('teachers.edit',$teacher->id) }}">@lang('laravel-events-calendar::general.edit')</a>
                                        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('teachers.show',$teacher->id) }}">@lang('laravel-events-calendar::general.view')</a>
                                        
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-link pl-0">@lang('laravel-events-calendar::general.delete')</button>
                                    </form>
                                </div>
                            {{-- Teachers directory  --}}
                            @else
                                <div class="col-12 pb-2 action">
                                    <a class="btn btn-primary float-right" href="{{ route('teachers.show',$teacher->id) }}">@lang('laravel-events-calendar::general.view')</a>
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
