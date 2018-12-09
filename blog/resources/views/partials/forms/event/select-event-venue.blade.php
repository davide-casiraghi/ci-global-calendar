
<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="form-group" >
            <strong>@lang('views.venues'):</strong>
            <select name="venue_id" class="selectpicker" title="@lang('homepage-serach.venue_name')" data-live-search="true">
                @foreach ($venues as $value => $venue)
                    <option value="{{$venue->id}}" @if(!empty($event->venue_id)) {{ $event->venue_id == $venue->id ? 'selected' : '' }} @endif>{!! $venue->name !!} - {!! $venue->city !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6">
        <button type="button" data-toggle="modal" class="btn btn-primary mb-3 mb-sm-0 mt-sm-4" data-remote="{{ route('eventVenues.modal') }}" data-target=".modalFrame">@lang('views.add_new_venue')</button>
    </div>
</div>
