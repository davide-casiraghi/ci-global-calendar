{{--
    HIDDEN INPUT form field
    
    PARAMETERS:
        - $title: string - the content of the label
        - $name: string - the table field name
        - $tooltip: string - the content of the tooltip
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
