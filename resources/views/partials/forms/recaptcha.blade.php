{{--
    Recaptcha google v2 - https://github.com/anhskohbo/no-captcha
    
    PARAMETERS:
        none
--}}

@section('javascript-head')
    @parent
    {!! NoCaptcha::renderJs() !!}
@stop

<div class="recaptcha">
    
    {!! NoCaptcha::display() !!}

    @if ($errors->has('g-recaptcha-response'))
        <div class="alert alert-danger mt-3">
            {{ $errors->first('g-recaptcha-response') }}
        </div>
    @endif
    
</div>
