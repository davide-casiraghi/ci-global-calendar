<div class="form-group">
    <label for="{{ $name }}">{{ $title }}:</label>

    <input type="text" name="{{ $name }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
        @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
        @if(!empty($value)) value="{{ $value }}" @endif
    >

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
