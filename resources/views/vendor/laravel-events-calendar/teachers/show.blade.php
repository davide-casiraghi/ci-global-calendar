@extends('laravel-events-calendar::teachers.layout')

@section('title'){{ $teacher->name }}@endsection
@section('description')Teacher profile @ Global CI calendar @endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $teacher->name }}" />
    
    @if(!empty($teacher->profile_picture))
        <meta property="og:image" content="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" />
    @else
        <meta property="og:image" content="/storage/logo/fb_logo_cigc_red.jpg" />
    @endif
@endsection    

@section('content')

    <div class="row">
        <div class="container max-w-md px-0">
            
            {{-- Teacher Intro Infos --}}
                <div class="row m-0 p-4 white-bg rounded">
                    <div class="teacherName col-12 mb-3">
                        <h4>{{ $teacher->name }}</h4>
                    </div>
                    <div class="col-12">
                        @if(!empty($country->name))
                            <div class="row">
                                <div class="col-12">
                                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                                    {{ $country->name }}
                                </div>
                            </div> 
                        @endif
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <div class="col-6">
                                @if(!empty($teacher->year_starting_practice))<b>@lang('views.year_of_starting_to_practice')<br /> </b>{{ $teacher->year_starting_practice }}@endif
                            </div>
                            <div class="col-6">
                                @if(!empty($teacher->year_starting_teach))<b>@lang('views.year_of_starting_to_teach')<br /> </b>{{ $teacher->year_starting_teach }}@endif
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            @if(!empty($teacher->facebook))
                                <div class="col-6">
                                    <i title="" class="fab fa-facebook-square mr-1 dark-gray"></i>
                                    <a href="{{ $teacher->facebook }}" target="_blank">@lang('views.facebook_profile')</a>
                                </div>
                            @endif
                            @if(!empty($teacher->website))
                                <div class="col-6">
                                    <i class="fas fa-globe mr-1 dark-gray"></i>
                                    <a href="{{ $teacher->website }}" target="_blank">@lang('views.website')</a>
                                </div> 
                            @endif 
                        </div>
                    </div>
                </div>
            
            {{-- Teacher Bio / Photo --}}
                @if(!empty($teacher->bio))
                    <div class="row m-0 p-4 white-bg rounded mt-2">
                        <div class="col-12 mt-3">
                            @if(!empty($teacher->profile_picture))
                                <img class="ml-3 float-right img-fluid mb-2" alt="{{ $teacher->name }}" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" >
                            @endif
                            {!! $teacher->bio !!}
                        </div>
                        <div class="col-12 mt-3">
                            @if(!empty($teacher->significant_teachers))
                                <h5>@lang('views.significant_teachers')</h5>
                                {{$teacher->significant_teachers}}
                            @endif
                        </div>
                    </div>
                @endif
        </div>
        
        
        {{-- Teacher will teach --}}
            @if(count($eventsTeacherWillTeach))
                <div class="col-12 mt-5">
                    <h4 class="mb-4">This teacher will teach in this events</h4>
                    
                    <div class="eventSearch">
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-12">
                                    @include('laravel-events-calendar::partials.event-list', [
                                          'events' => $eventsTeacherWillTeach,
                                          'iframeLinkBlank' => false,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            @endif
            
            
    </div>

@endsection
