@extends('teachers.layout')

@section('title'){{ $teacher->name }}@endsection

@section('fb-tags')
    <meta property="og:title" content="{{ $teacher->name }}" />
@endsection    

@section('content')

    <div class="row">
        <div class="teacherName col-12 mb-5">
            <h2>{{ $teacher->name }}</h2>
        </div>

        @if(!empty($teacher->bio))
            <div class="teacherBio col-12">
                <h3>Bio</h3>
                <img class="teacherPhoto ml-3" src="/storage/images/teachers_profile/thumb_{{ $teacher->profile_picture }}" style="width:345px; float:right;">
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
        
            
        

        

        
        
        @if(count($eventsTeacherWillTeach))
            <div class="col-12 mt-5">
                <h4 class="mb-4">This teacher will teach in this events</h4>
                
                {{--<ul>
                    @foreach ($eventsTeacherWillTeach as $event)
                        <li>
                            <a href="/event/{{$event->slug}}">{{$event->title}}</a>
                            - {{$event->sc_country_name}}
                            - {{$event->sc_city_name}}
                            - @date($event->start_repeat) - @date($event->end_repeat)
                        </li>
                    @endforeach
                </ul>--}}
                
                <div class="eventSearch">
                    <div class="container">
                        <div class="eventList mb-3">
                            @foreach ($eventsTeacherWillTeach as $event)
                                <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                                    <div class="col-lg-1 date">
                                        <div class="row text-uppercase">

                                        {{-- One day event --}}
                                        @if ($event->start_repeat == $event->end_repeat)
                                            <div class='dateBox col text-center bg-secondary text-white px-2 vcenter' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                                                <strong>
                                                    @day($event->start_repeat)<br class="d-none d-lg-block"/>
                                                    @month($event->start_repeat)
                                                </strong>
                                            </div>
                                        {{-- Many days event --}}
                                        @else
                                            <div class='col text-center bg-secondary text-white px-1 mr-1' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                                                <strong>
                                                    @day($event->start_repeat)<br class="d-none d-lg-block"/>
                                                    @month($event->start_repeat)
                                                </strong>
                                            </div>
                                            <div class='col text-center bg-secondary text-white px-1' data-toggle="tooltip" data-placement="top" title="@date($event->end_repeat)">
                                                <strong>
                                                    @day($event->end_repeat)<br class="d-none d-lg-block"/>
                                                    @month($event->end_repeat)
                                                </strong>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3 py-3 py-md-0 vcenter title">
                                        {{--<a href="{{ route('events.show',$event->id) }}">{{ $event->title }}</a>--}}
                                        <a href="{!! route('events.show', ['id'=>$event->id, 'rp_id'=>$event->rp_id])  !!}">
                                            {{ str_limit($event->title, $limit = 50, $end = '...') }}
                                        </a>
                                    </div>
                                    <div class="col-md-3 vcenter teachers">
                                        @if(!empty($event->sc_teachers_names))
                                        <i data-toggle="tooltip" data-placement="top" title="Teachers" class="far fa-users mr-2"></i>
                                        <div class="names">
                                            {{ $event->sc_teachers_names }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-2 vcenter category mt-2 mt-md-0">
                                        <i data-toggle="tooltip" data-placement="top" title="Category" class="fa fa-tag mr-2"></i>
                                        {{ $eventCategories[$event->category_id] }}
                                    </div>
                                    <div class="col-md-4 col-lg-3 vcenter location mt-2 mt-md-0">
                                        <i data-toggle="tooltip" data-placement="top" title="Venue" class="far fa-map-marker-alt mr-2" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;"></i>
                                        <div class="details">
                                            {{ $event->sc_venue_name }}<br />
                                            {{ $event->sc_city_name }},
                                            {{ $event->sc_country_name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
             
        @endif
    </div>

@endsection
