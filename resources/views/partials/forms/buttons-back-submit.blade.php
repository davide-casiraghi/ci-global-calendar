{{-- Submit --}}
    <button type="submit" class="btn btn-primary float-right">@lang('general.submit')</button>

{{-- Back --}}
    @if(!empty($route))
        @if(empty($routeParameter))
            <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route) }}">@lang('general.back')</a>
        @else
            <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route, $routeParameter) }}">@lang('general.back')</a>
        @endif   
    @endif  

    @if(!empty($url))
        @if(empty($urlParameters))
            <a class="btn btn-outline-primary mr-2 float-right" href="/{{ $url }}">@lang('general.back')</a>
        @else
            <a class="btn btn-outline-primary mr-2 float-right" href="/{{ $url }}/?param1=33">@lang('general.back')</a>
        @endif   
    @endif  
