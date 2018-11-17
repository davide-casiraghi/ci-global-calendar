<div class="form-group">
    <strong>Status:</strong>
    <select name="status" class="form-control">
        <option value="PUBLISHED" @if(!empty($event->status)) {{  $event->status == 'PUBLISHED' ? 'selected' : '' }} @endif>Published</option>
        <option value="UNPUBLISHED" @if(!empty($event->status)) {{  $event->status == 'UNPUBLISHED' ? 'selected' : '' }} @endif>Unpublished</option>
    </select>
</div>
