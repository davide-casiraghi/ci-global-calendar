<div class="form-group">
    <strong>{{ $title }}:</strong>
    <textarea class="form-control" style="height:150px" name="{{ $name }}" placeholder="{{ $placeholder }}" id="bodyTextarea">@if(!empty($value)){!! $value !!} @endif</textarea>
</div>
