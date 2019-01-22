{{--
    HIDDEN INPUT form field
    
    PARAMETERS:
        - $name: string - the table field name
        - $value: the already stored value (used in edit view to retrieve the already stored value)
--}}
<div class="form-group">
    @if(!empty($title))
        <label for="{{ $name }}">{{ $title }}</label>
        @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
    @endif
    

    <input type="text" name="{{ $name }}" class="form-control"
        @if(!empty($value)) value="{{ $value }}" @endif
    readonly>

</div>
