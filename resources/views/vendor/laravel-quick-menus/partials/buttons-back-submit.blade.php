{{-- Submit --}}
    <button type="submit" class="btn btn-primary float-right">@lang('laravel-quick-menus::general.submit')</button>

{{-- Back --}}
    @if(empty($routeParameter))
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route) }}">@lang('laravel-quick-menus::general.back')</a>
    @else
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route, $routeParameter) }}">@lang('laravel-quick-menus::general.back')</a>
    @endif   
