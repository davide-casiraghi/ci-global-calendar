
{{--
    Email for user activation - sent to administrator by App/Mail/userActivation
--}}

@component('mail::message')

# Hello administrator

A new user has registered on the CI Global calendar website.  

 **Name:** {{$name}}  
 **Email:**: {{$email}}  
 **Country:**: {{$country}}  
 **Description:**
 {{$description}}

@component('mail::button', ['url' => config('app.url').'/verify-user/'.$activation_code])
Activate user
@endcomponent

@component('mail::button', ['url' => 'mailto:'.$email])
Write to {{$name}}
@endcomponent

Thanks,  
{{ config('app.name') }}  

<sub><sup>If you’re having trouble clicking the "Activate user" button, copy and paste the URL below into your web browser:  
{{config('app.url').'/verify-user/'.$activation_code}}</sup></sub>

@endcomponent
