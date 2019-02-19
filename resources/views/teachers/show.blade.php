@extends('teachers.layout')

@section('title'){{ $teacher->name }}@endsection
@section('description')Teacher profile @ Global CI calendar @endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $teacher->name }}" />
@endsection    

@section('content')

    <div class="row">
        <div class="container max-w-md px-0">
            <div class="teacherName col-12 mb-4">
                <h3>{{ $teacher->name }}</h3>
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
                @if(!empty($teacher->year_starting_practice))<p><b>Year of starting to practice: </b>{{ $teacher->year_starting_practice }}</p>@endif
                @if(!empty($teacher->year_starting_teach))<p><b>Year of starting to teach:</b>{{ $teacher->year_starting_teach }}</p>@endif
                
                <div class="row mt-2">
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
            
            @if(!empty($teacher->bio))
                <div class="teacherBio col-12 mt-5">
                    <h4>Bio</h4>
                    <img class="teacherPhoto ml-3" alt="{{ $teacher->name }}" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" style="width:345px; float:right;">
                    {!! $teacher->bio !!}
                </div>
            @endif

            
        </div>
        
        

        @if(count($eventsTeacherWillTeach))
            <div class="col-12 mt-5">
                <h4 class="mb-4">This teacher will teach in this events</h4>
                
                <div class="eventSearch">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.event-list', [
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
