
{{-- 
    textarea-plain partial provide a textarea without tinymce editor.
--}}

<div class="form-group">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}</label>@endif
    <textarea   class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
                style="height: @if(!empty($height)){{ $height }}@else{{'9rem'}}@endif" 
                name="{{ $name }}" 
                @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif 
    >@if(!empty($value)){!! $value !!} @endif</textarea>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
