@section('javascript-document-ready')
    @parent
    $('#timepicker_end').timepicker();
@stop

<div class="form-group">
    <strong>Time End:</strong>
    <div class="input-group bootstrap-timepicker timepicker">
        <input id="timepicker_end" name="time_end" @if(!empty($dateTime['timeEnd'])) value="{{ $dateTime['timeEnd'] }}" @endif type="text" class="form-control input-small" aria-describedby="time-addon">
        <div class="input-group-append">
            <span class="input-group-text" id="time-addon"><i class="far fa-clock"></i></span>
        </div>
    </div>
</div>
