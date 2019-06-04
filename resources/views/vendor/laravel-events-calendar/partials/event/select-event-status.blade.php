<div class="form-group">
    <label for="status">@lang('laravel-events-calendar::general.status')</label>
    <select name="status" class="form-control">
        <option value="2" @if(!empty($event->status)) {{  $event->status == '2' ? 'selected' : '' }} @endif>@lang('laravel-events-calendar::general.published')</option>
        <option value="1" @if(!empty($event->status)) {{  $event->status == '1' ? 'selected' : '' }} @endif>@lang('laravel-events-calendar::general.unpublished')</option>
    </select>
</div>
