<div class="form-group">
    <strong>@lang('views.status'): </strong>
    <select name="status" class="form-control">
        <option value="2" @if(!empty($event->status)) {{  $event->status == '2' ? 'selected' : '' }} @endif>@lang('views.published')</option>
        <option value="1" @if(!empty($event->status)) {{  $event->status == '1' ? 'selected' : '' }} @endif>@lang('views.unpublished')</option>
    </select>
</div>
