
{{--

    EVENT LIST
    Show the responsive list of events: used in hp search, teacher show view and regional iframe

    PARAMETERS:
        - $events: array - the list of events
        - $iframeLinkBlank: boolean - if true clicking on an event bring the user out of the IFRAME where the page was loaded (used for regional websites)
--}}

<div class="eventList mb-3">
    @forelse ($events as $event)
        <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
            <div class="col-lg-1 date">
                <div class="row text-uppercase h-100">

                {{-- One day event --}}
                @if (Carbon\Carbon::parse($event->start_repeat)->format('d-m-Y') == Carbon\Carbon::parse($event->end_repeat)->format('d-m-Y'))
                    <div class='dateBox col text-center bg-secondary text-white px-2 vcenter' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                        <strong>
                            @day($event->start_repeat)<br class="d-none d-lg-block"/>
                            @month($event->start_repeat)
                        </strong>
                    </div>
                {{-- Many days event --}}
                @else
                    <div class='col text-center bg-secondary text-white px-1 mr-1' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                        <div class="d-table text-center h-100 w-100">
                            <strong class="align-middle d-table-cell">
                                @day($event->start_repeat)<br class="d-none d-lg-block"/>
                                @month($event->start_repeat)
                            </strong>
                        </div>
                    </div>
                    <div class='col bg-secondary text-white px-1' data-toggle="tooltip" data-placement="top" title="@date($event->end_repeat)">
                        <div class="d-table text-center h-100 w-100">
                            <strong class="align-middle d-table-cell">
                                @day($event->end_repeat)<br class="d-none d-lg-block"/>
                                @month($event->end_repeat)
                            </strong>
                        </div>
                    </div>
                @endif
                </div>
            </div>
            <div class="col-md-3 py-3 py-md-0 vcenter title">
                {{--<a href="{{ route('events.show',$event->id) }}">{{ $event->title }}</a>--}}
                <a href="/event/{{$event->slug}}/{{$event->rp_id}}" @if($iframeLinkBlank)  onclick="window.parent.location.href='https://ciglobalcalendar.net/event/{{$event->slug}}/{{$event->rp_id}}';" @endif>
            {{--    {!! route('events.show', ['id'=>$event->id, 'rp_id'=>$event->rp_id])  !!}">--}}
                    {{ Str::limit($event->title, $limit = 50, $end = '...') }}
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
                    {{ $event->venue_name }}<br />
                    {{ $event->city }},
                    {{ $event->country }}
                </div>
            </div>
            {{--<div class="col-md-1 vcenter facebook mt-2 mt-md-0">
                @if(!empty($event->facebook_event_link))
                    <a href='{{ $event->facebook_event_link }}' target='_blank'><i class='fab fa-facebook-square' data-toggle="tooltip" data-placement="top" title="Facebook event"></i></a>
                @endif
            </div>--}}
        </div>
    
    @empty
        <strong>no events found</strong>
    @endforelse
    
    
</div>
