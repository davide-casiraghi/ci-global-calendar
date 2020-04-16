@section('javascript-document-ready')
    @parent
    
    $("#writeToOrganizerForm").submit(function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            user_name: "required",
            user_email: {
                required: true,
                email: true
            },
            message: "required",
        },
        submitHandler: function(form) {
            var firstNumber = parseInt($("#writeToOrganizerForm input[name=first_number]").val(), 10);
            var secondNumber = parseInt($("#writeToOrganizerForm input[name=second_number]").val(), 10);
            var captchaResult = parseInt($("#writeToOrganizerForm input[name=captcha_result]").val(), 10);
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


{{-- Button - Write for more info --}}
    @if(!empty($event->contact_email))
        <button type="button" class="btn btn-primary button-small" data-toggle="modal" data-target="#writeToOrganizerModal" data-whatever="@getbootstrap">@lang('laravel-events-calendar::event.write_for_more_info')</button>
    @endif
    
{{-- Modal --}}
    <div class="modal fade text-left" id="writeToOrganizerModal" tabindex="-1" role="dialog" aria-labelledby="writeToOrganizerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content light-gray-bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="writeToOrganizerModalLabel">@lang('laravel-events-calendar::event.write_for_more_info')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="writeToOrganizerForm" action="{{ route('events.organizer-message') }}" method="POST">
                    <div class="modal-body">
                             @csrf
                             @honeypot
                             <p>@lang('laravel-events-calendar::event.write_for_more_info_details')</p>
                             @include('laravel-form-partials::input', [
                                   'title' => __('laravel-events-calendar::general.your_name'),
                                   'name' => 'user_name',
                                   'required' => true,
                             ])

                             @include('laravel-form-partials::input', [
                                   'title' => __('laravel-events-calendar::general.your_email'),
                                   'name' => 'user_email',
                                   'required' => true,
                             ])

                             @include('laravel-form-partials::textarea-plain', [
                                   'title' => __('laravel-events-calendar::general.message'),
                                   'name' => 'message',
                                   'placeholder' => '',
                                   'required' => true,
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
                                   'name' => 'contact_email',
                                   'value' => $event->contact_email
                             ])

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">@lang('general.close')</button>
                        <button type="submit" class="btn btn-primary">@lang('general.send')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
