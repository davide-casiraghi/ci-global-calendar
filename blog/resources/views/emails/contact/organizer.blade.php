@component('mail::message')
# Introduction {{$sender_name}}

{{$event_title}}
{{$msg}}


{{$sender_email}}
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
