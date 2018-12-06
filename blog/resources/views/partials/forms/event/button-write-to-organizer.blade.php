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
                         <p>You are about to report a violation of the calendar <a href="/post/terms_of_use" target="_blank">terms of use</a><br></p>
                         <div class="form-group">
                             <strong>Reason:</strong>
                             <select name="reason" class="selectpicker" title="Select one option">
                                 <option value="1">Not about Contact Improvisation</option>
                                 <option value="2">Contains wrong informations</option>
                                 <option value="3">It is not translated in english</option>
                                 <option value="4">Other (specify in the message)</option>
                             </select>
                         </div>

                         @include('partials.forms.textarea-plain', [
                               'title' => 'Message (optional)',
                               'name' => 'message',
                               'placeholder' => 'Include all the details you can'
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
