{{--
    INPUT PASSWORD form field
    
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
--}}

<div class="form-group">
    @if(!empty($title))
        <label for="{{ $name }}">{{ $title }}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
    @endif
    <input type="password" name="{{ $name }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}">
    
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
