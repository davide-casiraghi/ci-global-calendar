
@component('mail::message')

# Message from the Global CI Calendar

You have received a message from **{{$sender_name}}**.

{{$msg}}


@component('mail::button', ['url' => 'mailto:'.$sender_email])
Reply to {{$sender_name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent



{{--
<h2>Message from the global calendar</h2>
<p>{{$name}} wrote a message</p>

<strong>Message:</strong>
<div class="">
    {{$msg}}
</div>
--}}
