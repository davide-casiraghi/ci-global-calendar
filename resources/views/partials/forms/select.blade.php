@section('javascript-document-ready')
    @parent
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        $('.selectpicker').selectpicker('mobile');
    }
@stop

<div class="form-group">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}</label>@endif
    <select name="{{ $name }}" class="selectpicker" data-live-search="true" title="{{$placeholder}}">
        @foreach ($records as $value => $record)
            <option value="{{$value}}" @if(!empty($seleted)) {{  $seleted == $value ? 'selected' : '' }}@endif>{{ $record }}</option>
        @endforeach
    </select>
</div>
