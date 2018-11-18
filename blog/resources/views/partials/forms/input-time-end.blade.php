@section('javascript')
    @parent
    javascript-time-end

@stop
<div class="form-group">
    <strong>Time End:</strong>
    <div class="input-group bootstrap-timepicker timepicker">
        <input id="timepicker_end" type="text" class="form-control input-small" aria-describedby="time-addon">
        <div class="input-group-append">
            <span class="input-group-text" id="time-addon"><i class="far fa-clock"></i></span>
        </div>
    </div>
</div>
