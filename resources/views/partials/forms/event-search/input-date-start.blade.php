
@section('javascript-document-ready')
    @parent

    var today = new Date();

    $(".datepicker_start_date input").datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        todayHighlight: true,
        startDate: today
    });

    //$('.datepicker_start_date input').datepicker('setDate', today);
@stop

<div class="form-group">
    <div class="input-group input-append date datepicker_start_date" data-date-format="dd-mm-yyyy">
        <div class="input-group-append">
          <div class="input-group-text">@lang('homepage-serach.start_on')<i class="far fa-calendar-alt ml-2"></i></div>
        </div>
        <input name="startDate" id="startDate" class="form-control" type="text" placeholder="Select date" @if(!empty($searchStartDate)) value="{{ $searchStartDate }}" @endif readonly="readonly" aria-describedby="startDate">

    </div>
</div>
