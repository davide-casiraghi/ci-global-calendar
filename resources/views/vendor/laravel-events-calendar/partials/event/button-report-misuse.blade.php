@section('javascript-document-ready')
    @parent
    
    $("#reportMisuseForm").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            reason: "required",
            user_email: {
                required: true,
                email: true
            },
        },
        submitHandler: function(form) {
            
            var firstNumber = parseInt($("#reportMisuseForm input[name=first_number]").val(), 10);
            var secondNumber = parseInt($("#reportMisuseForm input[name=second_number]").val(), 10);
            var captchaResult = parseInt($("#reportMisuseForm input[name=captcha_result]").val(), 10);
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

{{-- Button --}}
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#reportMisuseModal" data-whatever="@getbootstrap">@lang('laravel-events-calendar::misuse.report_misuse')</button>

{{-- Modal --}}
    <div class="modal fade text-left" id="reportMisuseModal" tabindex="-1" role="dialog" aria-labelledby="reportMisuseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content light-gray-bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportMisuseModalLabel">@lang('laravel-events-calendar::misuse.report_misuse')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="reportMisuseForm" action="{{ route('events.misuse') }}" method="POST">
                    <div class="modal-body">
                             @csrf
                             @honeypot
                             <p>@lang('laravel-events-calendar::misuse.report_violation') <a href="/posts/19" target="_blank"><i class="far fa-link"></i></a><br></p>
                             <div class="form-group">
                                 <strong>@lang('laravel-events-calendar::misuse.reason') <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('laravel-events-calendar::general.required')">*</span></strong>
                                 <select name="reason" class="selectpicker" title="@lang('laravel-events-calendar::misuse.select_one_option')">
                                     <option value="1">@lang('laravel-events-calendar::misuse.not_about_ci')</option>
                                     <option value="2">@lang('laravel-events-calendar::misuse.contains_wrong_info')</option>
                                     <option value="3">@lang('laravel-events-calendar::misuse.not_translated_english')</option>
                                     <option value="4">@lang('laravel-events-calendar::misuse.other')</option>
                                 </select>
                             </div>

                             @include('laravel-form-partials::input', [
                                   'title' => __('laravel-events-calendar::general.your_email'),
                                   'name' => 'user_email',
                                   'required' => true,
                             ])
                             
                             @include('laravel-form-partials::textarea-plain', [
                                   'title' => __('laravel-events-calendar::misuse.message'),
                                   'name' => 'message_misuse',
                                   'placeholder' => __('laravel-events-calendar::misuse.include_all_details'),
                                   'required' => false,
                             ])
                             
                             {{--@include('laravel-form-partials::recaptcha')--}}
                             
                             @php 
                                 $random_number1 = rand(1, 8);
                                 $random_number2 = rand(1, 8);
                             @endphp
                             @include('laravel-form-partials::recaptcha-sum', [
                                'randomNumber1' => $random_number1,
                                'randomNumber2' => $random_number2,
                             ])

                             @include('laravel-form-partials::input-hidden', [
                                   'name' => 'event_title',
                                   'value' => $event->title
                             ])

                             @include('laravel-form-partials::input-hidden', [
                                   'name' => 'event_id',
                                   'value' => $event->id
                             ])
                             
                             @include('laravel-form-partials::input-hidden', [
                                   'name' => 'event_slug',
                                   'value' => $event->slug
                             ])
                             
                             @include('laravel-form-partials::input-hidden', [
                                   'name' => 'created_by',
                                   'value' => $event->created_by
                             ])
                             
                             {{-- ADD HERE HIDDEN ORGANIZER MAIL --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">@lang('general.close')</button>
                        <button type="submit" class="btn btn-primary">@lang('general.send')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
