@section('javascript-document-ready')
    @parent
    $('#datepicker_end_date input').datepicker();
@stop

<div class="form-group">
    <div class="input-group input-append date" id="datepicker_end_date" data-date-format="dd-mm-yyyy">
        <div class="input-group-append">
          <div class="input-group-text">End on (or before)<i class="far fa-calendar-alt ml-2"></i></div>
        </div>
        <input name="endDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-end">
    </div>
</div>
