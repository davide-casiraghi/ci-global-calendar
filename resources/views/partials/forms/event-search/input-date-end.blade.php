@section('javascript-document-ready')
    @parent

    var today = new Date();

    $(".datepicker_end_date input").datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        todayHighlight: true,
        startDate: today
    });

@stop

<div class="form-group">
    <div class="input-group input-append date datepicker_end_date">
        {{--<div class="input-group-append">
          <div class="input-group-text">@lang('homepage-serach.end_on')<i class="far fa-calendar-alt ml-2"></i></div>
      </div>--}}
        <input name="endDate" id="endDate" class="form-control" type="text" placeholder="@lang('homepage-serach.end_on')" @if(!empty($searchEndDate)) value="{{ $searchEndDate }}"@endif readonly="readonly" aria-describedby="endDate" aria-label="Enter end date">
    </div>
</div>
