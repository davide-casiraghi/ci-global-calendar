
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title') - @lang('homepage-serach.contact_improvisation') - @lang('homepage-serach.global_calendar')</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        
    {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
        <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
            
        {{-- Google Analitics (before closing the head )--}}
        @include('partials.google-analytics')
        
</head>

<body> {{-- Laravel use VUE as default - https://stackoverflow.com/questions/41411344/vue-warn-cannot-find-element-app#41411385 --}}
    
    @if(!env('SITE_OFFLINE'))
        <div id="app" class="container pt-5">
            @yield('content')
        </div>
    @else
        @include('partials.offline-for-maintenance')
    @endif

</body>
</html>
