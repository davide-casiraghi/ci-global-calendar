@section('javascript-document-ready')
    @parent
    var today = new Date();

    $('#datepicker_start_date input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        startDate: today
    });
@stop

<div class="form-group">
    <label for="{{ $name }}">Date Start</label>
    <div class="input-group input-append date" id="datepicker_start_date" data-date-format="dd-mm-yyyy">
        <input name="startDate" id="startDate" class="form-control" type="text" @if(!empty($dateTime['dateStart'])) value="{{ $dateTime['dateStart'] }}" @endif placeholder="Select date" value="" readonly="readonly" aria-describedby="startDate" aria-label="Enter start date">
        <div class="input-group-append">
            <span class="input-group-text" id="date-addon-start"><i class="far fa-calendar-alt"></i></span>
        </div>
    </div>
</div>
