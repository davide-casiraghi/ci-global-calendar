<div class="form-group">
    <strong>{{ $title }}:</strong>
    <input type="text" name="{{ $name }}" class="form-control"
        @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
        @if(!empty($value)) value="{{ $value }}" @endif
    >
</div>
