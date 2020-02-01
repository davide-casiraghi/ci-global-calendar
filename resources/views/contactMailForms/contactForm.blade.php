@extends('contactMailForms.layout')

@section('javascript-document-ready')
    @parent
    
    $("#contactForm").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            message: "required",
        },
        submitHandler: function(form) {
            
            var firstNumber = parseInt($("#contactForm input[name=first_number]").val(), 10);
            var secondNumber = parseInt($("#contactForm input[name=second_number]").val(), 10);
            var captchaResult = parseInt($("#contactForm input[name=captcha_result]").val(), 10);
            var checkTotal = firstNumber + secondNumber;
            
            if (captchaResult !== checkTotal){
                alert('Please resolve the simple sum to proceed');
            } 
            else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                form.submit();
          }
        }
    });
@stop

@section('content')
    <div class="container max-w-sm px-0">

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    @switch($recipient)
                        @case("administrator")
                            <h3>@lang('views.contact_the_administrator')</h3>
                        @break

                        @case("project-manager")
                            <h3>@lang('views.contact_the_project_manager')</h3>
                        @break
                        
                        @case("webmaster")
                            <h3>@lang('views.contact_the_webmaster')</h3>
                        @break

                        @case("test")
                            <h3>Contact test</h3>
                        @break
                    @endswitch

                </div>
            </div>
        </div>

        <form id="contactForm" action="{{ route('forms.contactform-send') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-12 mt-3 mb-2">
                    <div class='alert alert-warning' role='alert'>
                        @lang('views.please_write_in_english')
                    </div>
                </div>

                <div class="col-12">
                   @include('laravel-form-partials::input', [
                         'title' => __('general.name'),
                         'name' => 'name',
                         'placeholder' => '',
                         'required' => true,
                   ])
                </div>

               <div class="col-12">
                   @include('laravel-form-partials::input', [
                         'title' => __('general.email_address'),
                         'name' => 'email',
                         'placeholder' => '',
                         'required' => true,
                   ])
               </div>

               <div class="col-12">
                   @include('laravel-form-partials::textarea-plain', [
                         'title' => __('general.message'),
                         'name' => 'message',
                         'placeholder' => '',
                         'required' => true,
                   ])
               </div>
               
               <div class="col-12">
                   {{-- Recaptcha google v2 --}}
                   {{-- @include('laravel-form-partials::recaptcha')--}}
                    @php 
                        $random_number1 = rand(1, 8);
                        $random_number2 = rand(1, 8);
                    @endphp
                    @include('laravel-form-partials::recaptcha-sum', [
                        'randomNumber1' => $random_number1,
                        'randomNumber2' => $random_number2,
                    ])
               </div>
               
               @include('laravel-form-partials::input-hidden', [
                     'name' => 'recipient',
                     'value' => $recipient
               ])

           </div>

           <div class="row mt-5">
               <div class="col-6 pull-left">
                   <a class="btn btn-primary" href="{{ route('home') }}">@lang('general.back')</a>
               </div>
               <div class="col-6 pull-right">
                 <button type="submit" class="btn btn-primary float-right">@lang('general.send')</button>
               </div>
           </div>
       </form>
   </div>
@endsection
