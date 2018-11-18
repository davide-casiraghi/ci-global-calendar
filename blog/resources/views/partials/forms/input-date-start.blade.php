
@section('javascript')
    @parent
    javascript-date-start

@stop

<div class="form-group">
    <strong>Date Start:</strong>
    <div class="input-group input-append date" id="datepicker_start_date" data-date-format="dd-mm-yyyy">
        <input name="startDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-start">
        <div class="input-group-append">
            <span class="input-group-text" id="date-addon-start"><i class="far fa-calendar"></i></span>
        </div>
    </div>
</div>
