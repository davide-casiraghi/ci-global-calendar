{{--
    INPUT form field
    
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
        - $placeholder: string - the placeholder to show when no date selected
        - $value: the already stored value (used in edit view to retrieve the already stored value)
--}}

<div class="form-group">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}</label>@endif

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
