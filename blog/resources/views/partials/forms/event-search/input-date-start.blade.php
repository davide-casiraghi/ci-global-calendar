
@section('javascript-document-ready')
    @parent
    $('#datepicker_start_date input').datepicker();
@stop

<div class="form-group">
    <div class="input-group input-append date" id="datepicker_start_date" data-date-format="dd-mm-yyyy">
        <div class="input-group-append">
          <div class="input-group-text">Start on (or after)<i class="far fa-calendar-alt ml-2"></i></div>
        </div>
        <input name="startDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-start">

    </div>
</div>
