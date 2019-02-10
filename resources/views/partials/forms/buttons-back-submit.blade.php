<div class="row mt-5">
    <div class="col-6 pull-left">
        @if(empty($routeParameter))
            <a class="btn btn-primary" href="{{ route($route) }}">@lang('general.back')</a>
        @else
            <a class="btn btn-primary" href="{{ route($route, $routeParameter) }}">@lang('general.back')</a>
        @endif   
    </div>
    <div class="col-6 pull-right">
      <button type="submit" class="btn btn-primary float-right">@lang('general.submit')</button>
    </div>
</div>
