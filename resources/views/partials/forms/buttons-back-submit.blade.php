{{-- Submit --}}
    <button type="submit" class="btn btn-primary float-right">@lang('general.submit')</button>

{{-- Back --}}
    @if(empty($routeParameter))
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route) }}">@lang('general.back')</a>
    @else
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route, $routeParameter) }}">@lang('general.back')</a>
    @endif   
