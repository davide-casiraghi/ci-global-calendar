<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" name="{{$name}}" class="custom-control-input{{ $errors->has($name) ? ' is-invalid' : '' }}" id="customCheck1">
        <label class="custom-control-label" for="customCheck1">{{$description}}</label>
    </div>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
