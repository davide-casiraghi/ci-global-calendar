
@php ($barsBackground = '#B5A575')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@lang('homepage-serach.contact_improvisation') - @lang('homepage-serach.global_calendar')</title>
    {{--<title>{{ config('app.name', 'Laravel') }}</title>--}}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{$barsBackground}}"/> {{-- Theming the browser's address bar to match your brand's colors provides a more immersive user experience.--}}
    <meta name="description" content="@lang('homepage-serach.find_information')">
    
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
        
    <!-- debug for Vue.js - any environment, I need for Safari, remove it before go to production - https://github.com/vuejs/vue-devtools/blob/master/shells/electron/README.md -->
        <script src="http://localhost:8098"></script>
</head>

<body class=""> {{-- Laravel use VUE as default - https://stackoverflow.com/questions/41411344/vue-warn-cannot-find-element-app#41411385 --}}
    
    @if(!env('SITE_OFFLINE'))
        @include('laravel-quick-menus::menus.nav.nav', [
            'items' => $MyNavBar->roots(),
            'container' => true,
            'paddingX' => '',
            'backgroundColor' => $barsBackground,
            'stickyNavbar' => true,
            'transparentBarInHp' => true,
        ])

        <div id="app" class="beforeContent">
            @yield('beforeContent')
        </div>

        @include('footer.footer', [
            'container' => true,
            'paddingX' => '',
            'backgroundColor' => $barsBackground,
            'transparentBarInHp' => true,
            'stickyFooter' => false,
            'items' => DavideCasiraghi\LaravelQuickMenus\Models\MenuItem::getItemsTree(3),
        ])
        
        @include('partials.cookie-consent')
    
    @else
        @include('partials.offline-for-maintenance')
    @endif
    
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
