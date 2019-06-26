<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@hasSection('title')@yield('title') -@endif Events Calendar</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        
    {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
        <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @yield('css')
</head>

<body> 

        <div id="app">
            <div class="container mt-5">
                @yield('content')
            </div>
        </div>

    {{-- JS --}}
        <script src="{{ asset('js/manifest.js') }}" ></script>
        <script src="{{ asset('js/vendor.js') }}" ></script>
        <script src="{{ asset('js/app.js') }}" ></script>

        @yield('javascript')

        <script>
            $(document).ready(function(){
                @yield('javascript-document-ready')
            });
        </script>
</body>
</html>
