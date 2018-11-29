<div class="form-group">
    <strong>Status: </strong>
    <select name="status" class="form-control">
        <option value="2" @if(!empty($event->status)) {{  $event->status == '2' ? 'selected' : '' }} @endif>Published</option>
        <option value="1" @if(!empty($event->status)) {{  $event->status == '1' ? 'selected' : '' }} @endif>Unpublished</option>
    </select>
</div>
