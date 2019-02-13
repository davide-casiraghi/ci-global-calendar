
{{--
    TEXTAREA without tinymce editor.

    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when no text present 
        - $value: the already stored value (used in edit view to retrieve the already stored value)
--}}

<div class="form-group {{ $name }}">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}</label>@endif
    <textarea   class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
                style="height: @if(!empty($height)){{ $height }}@else{{'9rem'}}@endif" 
                name="{{ $name }}" 
                id="{{ $name }}" 
                @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif 
    >@if(!empty($value)){!! $value !!} @endif</textarea>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
