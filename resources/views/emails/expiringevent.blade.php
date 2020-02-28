@component('mail::message')

# Message from the Global CI Calendar

Dear {{$user_name}},

The event you published on the calendar called **{{$event_title}}**  
is going to expire in one week.

If the event is still continuing or if you are planning already to do it 
in the next season plase update the dates.

In this way it will not disappear.


@component('mail::button', ['url' => 'mailto:'.$sender_email])
Reply to {{$sender_name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
