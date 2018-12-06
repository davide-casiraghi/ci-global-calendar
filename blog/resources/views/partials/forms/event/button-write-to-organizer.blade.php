<p class="text-right my-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#writeToOrganizerModal" data-whatever="@getbootstrap">Write to the organizer</button>
</p>

<div class="modal fade" id="writeToOrganizerModal" tabindex="-1" role="dialog" aria-labelledby="writeToOrganizerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="writeToOrganizerModalLabel">Write to the organizer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('events.misuse') }}" method="POST">
                <div class="modal-body">
                         @csrf
                         <p>You are sending an email to the organizer of this event</a><br></p>
                         @include('partials.forms.input', [
                               'title' => 'Your email',
                               'name' => 'user_email',
                         ])

                         @include('partials.forms.textarea-plain', [
                               'title' => 'Message',
                               'name' => 'message',
                               'placeholder' => 'the text of your message'
                         ])

                         @include('partials.forms.input-hidden', [
                               'name' => 'event_title',
                               'value' => $event->title
                         ])

                         @include('partials.forms.input-hidden', [
                               'name' => 'event_id',
                               'value' => $event->id
                         ])

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
            </form>
        </div>
    </div>
</div>
