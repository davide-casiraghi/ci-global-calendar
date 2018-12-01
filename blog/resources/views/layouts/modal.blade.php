

    {{--<title>App Name - @yield('title')</title>--}}

    {{--<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS-->

        {{--<link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">}}

        @yield('css')
</head>

 <!-- Laravel use VUE as default - https://stackoverflow.com/questions/41411344/vue-warn-cannot-find-element-app#41411385-->
    {!! menu('main', 'nav') !!}

<body>
--}}
    <div class="container pt-5">
        @yield('content')
    </div>


    <!-- JS -->
        {{--<script src="{{ asset('js/manifest.js') }}" ></script>
        <script src="{{ asset('js/vendor.js') }}" ></script>
        <script src="{{ asset('js/app.js') }}" ></script>--}}

        @yield('javascript')

        <script type="text/javascript">
            $(document).ready(function(){
                @yield('javascript-document-ready')
            });
        </script>
