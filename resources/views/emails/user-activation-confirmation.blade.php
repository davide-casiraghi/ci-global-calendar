@component('mail::message')

# Hello {{$name}}  

Your account has been activated by the administrator.
Thank you for join the Global CI Calendar.

{{ config('app.name') }}
@endcomponent
