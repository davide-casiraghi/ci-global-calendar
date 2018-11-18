
@section('javascript')
    @parent
    javascript-time-start

@stop

<div class="form-group">
    <strong>Time Start:</strong>
    <div class="input-group bootstrap-timepicker timepicker">
        <input id="timepicker_start" type="text" class="form-control input-small" aria-describedby="time-addon-start">
        <div class="input-group-append">
            <span class="input-group-text" id="time-addon-start"><i class="far fa-clock"></i></span>
        </div>
    </div>
</div>
