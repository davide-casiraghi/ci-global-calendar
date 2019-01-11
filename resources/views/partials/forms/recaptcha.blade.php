
@section('javascript-head')
    @parent
    {!! NoCaptcha::renderJs() !!}
@stop

{{-- 
    Recaptcha google v2 
    https://github.com/anhskohbo/no-captcha
--}}
<div class="form-group row">
    <div class="col-md-4">

    </div>
    <div class="col-md-6">
        {!! NoCaptcha::display() !!}
        
        @if ($errors->has('g-recaptcha-response'))
            <div class="alert alert-danger mt-3">
                {{ $errors->first('g-recaptcha-response') }}
            </div>
        @endif
    </div>
</div>
