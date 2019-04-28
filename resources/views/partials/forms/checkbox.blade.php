{{--
    CHECKBOX form field
    
    PARAMETERS:
        - $name: string - the table field name
        - $description: string - the description to show
        - $value: the already stored value (used in edit view to retrieve the already stored value)
--}}

<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="{{$name}}" class="custom-control-input{{ $errors->has($name) ? ' is-invalid' : '' }}" id="{{$name}}" @if($value) checked @endif >
        <label class="custom-control-label" for="{{$name}}">{{$description}}</label>
    </div>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
