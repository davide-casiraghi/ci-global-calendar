
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@lang('homepage-serach.contact_improvisation') - @lang('homepage-serach.global_calendar')</title>
    {{--<title>{{ config('app.name', 'Laravel') }}</title>--}}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Facebook tags  --}}
        <meta property="og:image" content="/storage/logo/fb_logo_cigc_red.jpg" />

    {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
        <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @yield('css')
        
    {{-- JS that need to stay in the head--}}
        {{-- Google Analitics (before closing the head )--}}
        @include('partials.google-analytics')
        
</head>

<body class=""> {{-- Laravel use VUE as default - https://stackoverflow.com/questions/41411344/vue-warn-cannot-find-element-app#41411385 --}}
    {{-- {!! menu('main', 'nav') !!} --}}
    @include('menus.nav', [
        'items' => $MyNavBar->roots(),
        'container' => true,
        'paddingX' => '',
        'backgroundColor' => '#B5A575',
        'stickyNavbar' => true,
    ])

    <div id="app" class="beforeContent">
        @yield('beforeContent')
    </div>

    @include('footer.footer', [
        'container' => true,
        'paddingX' => '',
        'backgroundColor' => '#B5A575',
    ])
    
    @include('partials.cookie-consent')

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
