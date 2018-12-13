

@component('mail::message')

# Report from the Global CI Calendar

A user have reported this event:  
 **{{$event_title}}**.

**Reason**  
{{$reason}}

@component('mail::button', ['url' => config('app.url').'events/'.$event_id])
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
