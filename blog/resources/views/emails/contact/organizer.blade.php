@component('mail::message')

# Message from the Global CI Calendar

You have received a message from **{{$sender_name}}** about your event **{{$event_title}}**

{{$msg}}


{{$sender_email}}
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
