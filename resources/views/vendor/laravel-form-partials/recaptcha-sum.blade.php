{{--
    Recaptcha google v2 - https://github.com/anhskohbo/no-captcha
    
    PARAMETERS:
        $random_number1
        $random_number2
        
        http://html-tuts.com/simple-php-captcha/
--}}

<div class="recaptcha-sum">
    
    <p><b>@lang('laravel-form-partials::general.resolve_this_simple_sum'):</b> <br>
	    {{ $randomNumber1 }} + {{$randomNumber2 }} = 
		
		<input name="captcha_result" type="text" size="2" />

		<input name="first_number" type="hidden" value="{{ $randomNumber1 }}" />
		<input name="second_number" type="hidden" value="{{ $randomNumber2 }}" />
        
	</p>

</div>
