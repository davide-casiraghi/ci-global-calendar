{{-- Submit --}}
    <button type="submit" class="btn btn-primary float-right">Submit</button>

{{-- Back --}}
    @if(empty($routeParameter))
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route) }}">Back</a>
    @else
        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route($route, $routeParameter) }}">Back</a>
    @endif   
