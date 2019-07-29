
{{-- Button --}}
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#reportMisuseModal" data-whatever="@getbootstrap">@lang('misuse.report_misuse')</button>

{{-- Modal --}}
    <div class="modal fade text-left" id="reportMisuseModal" tabindex="-1" role="dialog" aria-labelledby="reportMisuseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content light-gray-bg">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportMisuseModalLabel">@lang('misuse.report_misuse')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('events.misuse') }}" method="POST">
                    <div class="modal-body">
                             @csrf 
                             <p>@lang('misuse.report_violation') <a href="/posts/19" target="_blank"><i class="far fa-link"></i></a><br></p>
                             <div class="form-group">
                                 <strong>@lang('misuse.reason') <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('laravel-events-calendar::general.required')">*</span></strong>
                                 <select name="reason" class="selectpicker" title="@lang('misuse.select_one_option')">
                                     <option value="1">@lang('misuse.not_about_ci')</option>
                                     <option value="2">@lang('misuse.contains_wrong_info')</option>
                                     <option value="3">@lang('misuse.not_translated_english')</option>
                                     <option value="4">@lang('misuse.other')</option>
                                 </select>
                             </div>

                             @include('laravel-form-partials::textarea-plain', [
                                   'title' => __('misuse.message'),
                                   'name' => 'message',
                                   'placeholder' => __('misuse.include_all_details'),
                                   'required' => true,
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
