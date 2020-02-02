{{--
    Recaptcha google v2 - https://github.com/anhskohbo/no-captcha
    
    PARAMETERS:
        $random_number1
        $random_number2
        
        http://html-tuts.com/simple-php-captcha/
--}}

<div class="form-group recaptcha-sum">
    
    <div class="">
        <b>@lang('laravel-form-partials::general.resolve_this_simple_sum'):</b> <br>
    </div>
     
    <div class="row">
        <div class="col text-right px-0 pt-1">
            {{ $randomNumber1Value }} + {{$randomNumber2Value }} = 
        </div>
        <div class="col">
            <input name="{{ $name }}" type="text" size="2" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"/>
            
            @if ($errors->has($name))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first($name) }}</strong>
                </span>
            @endif
        </div>
    </div>        
		
	<input name="{{ $randomNumber1Name }}" type="hidden" value="{{ $randomNumber1Value }}" />
	<input name="{{ $randomNumber2Name }}" type="hidden" value="{{ $randomNumber2Value }}" />
        
</div>
