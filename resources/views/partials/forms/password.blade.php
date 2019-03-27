{{--
    INPUT PASSWORD form field
    
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the table field name
--}}

<div class="form-group">
    <label for="{{ $name }}">{{ $title }}@if($required) <span data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
    <input type="password" name="{{ $name }}" class="form-control">
</div>
