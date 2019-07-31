{{-- Submit --}}
    <button type="submit" class="btn btn-primary float-right">@lang('laravel-form-partials::general.submit')</button>

{{-- Back --}}
    @if(empty($routeParameter))
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route) }}">@lang('laravel-form-partials::general.back')</a>
    @else
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route, $routeParameter) }}">@lang('laravel-form-partials::general.back')</a>
    @endif   
