
@component('mail::message')

# Message from the CI Global Calendar

{!! $msg !!}

{{--
@component('mail::button', ['url' => 'mailto:'.$sender_email])
Reply to {{$sender_name}}
@endcomponent
--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
