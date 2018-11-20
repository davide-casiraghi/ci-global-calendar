<div class="form-group">
    <strong>{{ $title }}:</strong>
    <input type="text" name="title" class="form-control" placeholder="Event title" @if(!empty($value)) value="{{ $value }}" @endif>
</div>
