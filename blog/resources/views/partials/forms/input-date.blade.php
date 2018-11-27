@section('javascript-document-ready')
    @parent
    // var today = new Date();

    $('#{{ $name }} input').datepicker({
        format: 'dd/mm/yyyy',
        // startDate: today
    });
@stop

<div class="form-group">
    <strong>{{ $title }}: </strong>
    <div class="input-group input-append date" id="{{ $name }}" data-date-format="dd-mm-yyyy">
        <input name="{{ $name }}" class="form-control" type="text" @if(!empty($value)) value="{{ $value }}" @endif placeholder="{{ $placeholder }}" value="" readonly="readonly" aria-describedby="date-addon-start">
        <div class="input-group-append">
            <span class="input-group-text" id="date-addon-start"><i class="far fa-calendar-alt"></i></span>
        </div>
    </div>
</div>
