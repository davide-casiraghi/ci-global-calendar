@section('javascript-document-ready')
    @parent

    var today = new Date();

    $(".datepicker_end_date input").datepicker({
        format: 'dd/mm/yy',
        startDate: today
    });

@stop

<div class="form-group">
    <div class="input-group input-append date datepicker_end_date">
        <div class="input-group-append">
          <div class="input-group-text">@lang('homepage-serach.end_on')<i class="far fa-calendar-alt ml-2"></i></div>
        </div>
        <input name="endDate" class="form-control" type="text" placeholder="Select date" @if(!empty($searchEndDate)) value="{{ $searchEndDate }}" readonly="readonly" aria-describedby="date-addon-end">
    </div>
</div>
