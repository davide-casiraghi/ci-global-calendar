@section('javascript-document-ready')
    @parent
    var today = new Date();

    $('#{{ $name }} input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        startDate: today
    });
@stop

<div class="form-group">
    <strong>{{ $title }}: </strong>

    {{-- Tooltip --}}
    @if(!empty($tooltipFontAwesomeClass) && !empty($tooltipText))
        <i data-toggle="tooltip" data-placement="top" title="" class="{{$tooltipFontAwesomeClass}}" data-original-title="{{$tooltipText}}"></i>
    @endif

    <div class="input-group input-append date" id="{{ $name }}" data-date-format="dd-mm-yyyy">
        <input
            name="{{ $name }}"
            class="form-control"
            type="text"
            @if(!empty($value)) value="{{ $value }}" @endif
            placeholder="{{ $placeholder }}"
            @if(!empty($endDate)) data-date-end-date="{{ $endDate }}" @endif
            readonly="readonly"
            aria-describedby="date-addon-start"
        >
        <div class="input-group-append">
            <span class="input-group-text" id="date-addon-start"><i class="far fa-calendar-alt"></i></span>
        </div>
    </div>
</div>
