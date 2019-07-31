@component('mail::message')

# Report from the Global CI Calendar

A user interested in your event is willing to read an english translation:   
Event name: **{{$event_title}}**.

**Reason**  
{{$reason}}

@if(!empty($msg))
**Message**  
{{$msg}}
@endif

@component('mail::button', ['url' => config('app.url').'event/'.$event_slug])
Show me the event
@endcomponent
@component('mail::button', ['url' => config('app.url').'events/'.$event_id.'/edit'])
Edit event
@endcomponent
{{--
@component('mail::button', ['url' => 'mailto:'.$sender_email])
Reply to {{$sender_name}}
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
