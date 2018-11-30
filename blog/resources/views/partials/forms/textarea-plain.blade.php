<div class="form-group">
    @if(!empty($title))<strong>{{ $title }}:</strong>@endif
    <textarea class="form-control" style="height: @if(!empty($height)){{ $height }}@else{{'9rem'}}@endif" name="{{ $name }}" placeholder="{{ $placeholder }}" id="bodyTextarea">@if(!empty($value)){!! $value !!} @endif</textarea>
</div>
