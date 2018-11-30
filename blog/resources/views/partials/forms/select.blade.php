<div class="form-group">
    @if(!empty($title))<strong>{{ $title }}:</strong>@endif
    <select name="{{ $name }}" class="selectpicker" data-live-search="true" title="{{$placeholder}}">
        @foreach ($records as $value => $record)
            <option value="{{$value}}">{{ $record }}</option>
        @endforeach
    </select>
</div>
