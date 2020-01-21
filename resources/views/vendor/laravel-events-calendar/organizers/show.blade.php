@extends('laravel-events-calendar::organizers.layout')

@section('title'){{ $organizer->name }}@endsection
@section('description')Organizer profile @ Global CI calendar @endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $organizer->name }}" />
    
    @if(!empty($organizer->profile_picture))
        <meta property="og:image" content="/storage/images/organizers_profile/thumb_{{ $organizer->profile_picture }}" />
    @else
        <meta property="og:image" content="/storage/logo/fb_logo_cigc_red.jpg" />
    @endif
    
@endsection    

@section('content')

    <div class="row">
        <div class="container max-w-md px-0">
            <div class="row m-0 p-4 white-bg rounded">
                <div class="orgaizerName col-12 mt-3">
                    <h4>{{ $organizer->name }}</h4>
                </div>

                @if(!empty($organizer->website))
                    <div class="col-12 mt-4">
                        <i class="fas fa-globe mr-1 dark-gray"></i>
                        <a href="{{ $organizer->website }}" target="_blank">@lang('laravel-events-calendar::general.website')</a>
                    </div>
                @endif
                
                @if(!empty($organizer->profile_picture))
                    <img class="ml-3 float-right img-fluid mb-3" alt="{{ $organizer->name }}" src="/storage/images/organizers_profile/thumb_{{ $organizer->profile_picture }}" >
                @endif

                @if(!empty($organizer->description))
                    <div class="col-12 mt-4">
                        <h4 class="mb-4">Description</h4>
                        {!! $organizer->description !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
