<div class="form-group">
    @if(!empty($title))<strong>{{ $title }}:</strong>@endif
    <textarea   class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" 
                style="height: @if(!empty($height)){{ $height }}@else{{'9rem'}}@endif" 
                name="{{ $name }}" 
                @if(!empty($placeholder))placeholder="{{ $placeholder }}"@endif 
                id="bodyTextarea">
                @if(!empty($value)){!! $value !!} @endif
    </textarea>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
