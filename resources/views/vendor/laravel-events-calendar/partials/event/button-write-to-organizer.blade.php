
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
                <form action="{{ route('events.organizer-message') }}" method="POST">
                    <div class="modal-body">
                             @csrf
                             <p>@lang('laravel-events-calendar::event.write_for_more_info_details')</p>
                             @include('laravel-events-calendar::partials.input', [
                                   'title' => 'Your name',
                                   'name' => 'user_name',
                                   'required' => true,
                             ])

                             @include('laravel-events-calendar::partials.input', [
                                   'title' => 'Your email',
                                   'name' => 'user_email',
                                   'required' => true,
                             ])

                             @include('laravel-events-calendar::partials.textarea-plain', [
                                   'title' => 'Message',
                                   'name' => 'message',
                                   'placeholder' => 'the text of your message',
                                   'required' => true,
                             ])

                             @include('laravel-events-calendar::partials.input-hidden', [
                                   'name' => 'event_title',
                                   'value' => $event->title
                             ])

                             @include('laravel-events-calendar::partials.input-hidden', [
                                   'name' => 'event_id',
                                   'value' => $event->id
                             ])
                             
                             @include('laravel-events-calendar::partials.input-hidden', [
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
