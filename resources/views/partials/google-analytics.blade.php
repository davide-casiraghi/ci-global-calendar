{{--

    GOOGLE ANALYTICS: Set up Analytics tracking
    
    to activate when include this partial declare a property in the .env file 
    with the tracking code, like:
    GOOGLE_ANALYTICS_TRACKING_CODE=UA-XXXXXXX-XX
    UA-3675475-42
--}}



@if (env('APP_ENV')=='production' && env('GOOGLE_ANALYTICS_TRACKING_CODE'))
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3675475-42"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', env('GOOGLE_ANALYTICS_TRACKING_CODE'));
    </script>

@endif
