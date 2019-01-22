

{{--

Iframe to embed in the regional websites:

EG.

    <iframe 
        width="560" 
        height="315" 
        src="https://www.ciglobalcalendar.net/eventSearch/country/SI" 
        frameborder="0">
    </iframe>



--}}

@extends('layouts.regionalframe')


<div class="eventSearch">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                
                <h2>Contact events in {{$country->name}}</h2>

                @include('partials.event-list', [
                      'events' => $events,
                      'iframeLinkBlank' => true,
                ])
                
                <small>Events from the <a href="https://ciglobalcalendar.net" onclick="window.parent.location.href='https://ciglobalcalendar.net';" >CI Global Calendar</a>. </small>
                {{--<p>
                    You can specify your country using one of this country codes:
                    <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements">Country code ISO_3166-1_alpha-2</a>
                </p>--}}
            </div>
        </div>
    </div>
</div>
