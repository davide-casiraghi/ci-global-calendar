{{--
    INPUT form field
    
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
        - $placeholder: string - the placeholder to show when no date selected
        - $tooltip: string - the content of the tooltip
        - $value: the already stored value (used in edit view to retrieve the already stored value)
        - $hide: if true 
--}}


<div class="form-group {{ $name }}" @if( !empty($hide)) style="display:none;" @endif>
    @if(!empty($title))
        <label for="{{ $name }}">{{ $title }}</label>
        @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
    @endif

    <input type="text" name="{{ $name }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
        @if(!empty($placeholder)) placeholder="{{ $placeholder }}" aria-label="{{ $placeholder }}" @endif
        @if(!empty($value)) value="{{ $value }}" @endif
    >

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
