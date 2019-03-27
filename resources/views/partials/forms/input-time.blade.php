
@section('javascript-document-ready')
    @parent
    $("input[name='{!!$name!!}']").timepicker({
        defaultTime: '{{$value}}'
    });
@stop


<div class="form-group">
    <label for="{{ $name }}">{{$title}}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
    <div class="input-group">
        <input type="text" name="{{$name}}" class="time_element form-control" />
        <div class="input-group-append">
            <span class="input-group-text"><i class="far fa-clock"></i></span>
        </div>
    </div>
</div>


{{-- @if(!empty($dateTime['timeStart'])) value="{{ $dateTime['timeStart'] }}" @endif --}}
