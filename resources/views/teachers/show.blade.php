@extends('teachers.layout')

@section('title'){{ $teacher->name }}@endsection
@section('description')Teacher profile @ Global CI calendar @endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $teacher->name }}" />
@endsection    

@section('content')

    <div class="row">
        <div class="container max-w-md px-0">
            
            <div class="row m-0 p-4 white-bg rounded">
                <div class="teacherName col-12 mb-4">
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
            </div>
            
            <div class="row m-0 p-4 white-bg rounded mt-2">
                @if(!empty($teacher->bio))
                    <div class="col-12 mt-3">
                        <img class="teacherPhoto ml-3 float-right img-fluid" alt="{{ $teacher->name }}" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" >
                        {!! $teacher->bio !!}
                    </div>
                    
                    {{--
                    <div class="container-fluid no-padding">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=1300%C3%97400&w=1300&h=400" alt="placeholder 960" class="img-responsive" />
                            </div>
                        </div>
                    </div>
                    --}}
                    
                @endif
            </div>
            

            
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
