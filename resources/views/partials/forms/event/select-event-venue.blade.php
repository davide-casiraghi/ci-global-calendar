
<div class="row">
    <div class="col-12">
        <div class="form-group" >
            <label>@lang('views.venues') <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span></label>
            <select name="venue_id" class="selectpicker" title="@lang('views.select_one')" data-live-search="true">
                @foreach ($venues as $value => $venue)
                    <option value="{{$venue->id}}" @if(!empty($event->venue_id)) {{ $event->venue_id == $venue->id ? 'selected' : '' }} @endif>{!! $venue->name !!} - {!! $venue->city !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 mb-1">
        <button type="button" data-toggle="modal" class="btn btn-primary float-right" data-remote="{{ route('eventVenues.modal') }}" data-target=".modalFrame"><i class="fa fas fa-plus-circle "></i> @lang('views.create_new_venue')</button>
    </div>
</div>
