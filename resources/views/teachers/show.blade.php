@extends('teachers.layout')

@section('title'){{ $teacher->name }}@endsection
@section('description')Teacher profile @ Global CI calendar @endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $teacher->name }}" />
@endsection    

@section('content')

    <div class="row">
        <div class="container max-w-md px-0">
            <div class="teacherName col-12 mb-5">
                <h2>{{ $teacher->name }}</h2>
            </div>

            @if(!empty($teacher->bio))
                <div class="teacherBio col-12">
                    <h3>Bio</h3>
                    <img class="teacherPhoto ml-3" alt="{{ $teacher->name }}" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" style="width:345px; float:right;">
                    {!! $teacher->bio !!}
                </div>
            @endif

            <div class="col-12 mt-4">
                @if(!empty($country->name))<p><b>Country: </b> {{ $country->name }}</p>@endif
                @if(!empty($teacher->year_starting_practice))<p><b>Year of starting to practice: </b>{{ $teacher->year_starting_practice }}</p>@endif
                @if(!empty($teacher->year_starting_teach))<p><b>Year of starting to teach:</b>{{ $teacher->year_starting_teach }}</p>@endif
                @if(!empty($teacher->facebook))<p><b>Facebook profile: </b><a href="{{ $teacher->facebook }}" target="_blank">{{ $teacher->facebook }}</a></p>@endif
                @if(!empty($teacher->website))<p><b>Website: </b><a href="{{ $teacher->website }}" target="_blank">{{ $teacher->website }}</a></p>@endif        
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
