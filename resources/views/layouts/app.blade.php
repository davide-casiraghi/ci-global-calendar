
@php ($barsBackground = '#B5A575')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@hasSection('title')@yield('title') -@endif @lang('homepage-serach.contact_improvisation') - @lang('homepage-serach.global_calendar')</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{$barsBackground}}"/> {{-- Theming the browser's address bar to match your brand's colors provides a more immersive user experience.--}}
    <meta name="description" content="@hasSection('description')@yield('description')@else @lang('homepage-serach.find_information')@endif">
    
    {{-- Facebook tags  --}}
        @yield('fb-tags')
        
    {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
        <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @yield('css')
        
    {{-- JS that need to stay in the head--}}
        @yield('javascript-head')
            
        {{-- Google Analitics (before closing the head )--}}
        @include('partials.google-analytics')
        
</head>

<body class="light-gray-bg"> {{-- Laravel use VUE as default - https://stackoverflow.com/questions/41411344/vue-warn-cannot-find-element-app#41411385 --}}
    
    @if(!env('SITE_OFFLINE'))
        @include('menus.nav.nav', [
            'container' => true,
            'paddingX' => '',
            'backgroundColor' => $barsBackground,
            'stickyNavbar' => true,
            'transparentBarInHp' => true,
        ])

        <div class="beforeContent pt-5">
            @yield('beforeContent')
        </div>

        <div id="app" class="container">
            @yield('content')
        </div>

        <div class="afterContent">
            @yield('afterContent')
        </div>
        
        @include('footer.footer', [
            'container' => true,
            'paddingX' => '',
            'backgroundColor' => $barsBackground,
            'stickyFooter' => true,
            'items' => App\MenuItem::getItemsTree(3),
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
