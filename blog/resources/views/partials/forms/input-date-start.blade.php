
@section('javascript-document-ready')
    @parent

    var today = new Date();

    $('#datepicker_start_date input').datepicker({
        format: 'dd/mm/yy',
        startDate: today
    });

@stop

<div class="form-group">
    <strong>Date Start:</strong>
    <div class="input-group input-append date" id="datepicker_start_date" data-date-format="dd-mm-yyyy">
        <input name="startDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-start">
        <div class="input-group-append">
            <span class="input-group-text" id="date-addon-start"><i class="far fa-calendar-alt"></i></span>
        </div>
    </div>
</div>
