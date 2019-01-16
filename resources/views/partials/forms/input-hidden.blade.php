{{--
    HIDDEN INPUT form field
    
    PARAMETERS:
        - $name: string - the table field name
        - $value: the already stored value (used in edit view to retrieve the already stored value)
--}}

<input type="hidden" name="{{ $name }}"
    @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
    @if(!empty($value)) value="{{ $value }}" @endif
>
