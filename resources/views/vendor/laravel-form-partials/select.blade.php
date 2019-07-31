{{--
    SELECT Dropdown that use bootstrap select - https://developer.snapappointments.com/bootstrap-select/

    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when nothing is selected 
        - $tooltip: string - the content of the tooltip
        - $value: the selected value
        - $record: the content of the selected value
        - $liveSearch: boolean - enable the live search
        - $mobileNativeMenu: boolean - enable mobile devices native menu for selectpicker menus
--}}

{{-- data-mobile="{{ $mobileNativeMenu }}" --}}

@section('javascript-document-ready')
    @parent
    @if($mobileNativeMenu)
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            $("select[name='{{$name}}']").selectpicker('mobile');
        }
    @endif
@stop

<div class="form-group {{ $name }}">
    @if(!empty($title))
        <label for="{{ $name }}">{{ $title }}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
        @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
    @endif
    <select name="{{ $name }}" id="{{ $name }}" class="selectpicker" data-live-search="{{ $liveSearch }}" title="{{$placeholder}}">
        @if(!empty($emptyState)) <option value="">@if(!empty($emptyStateText)){{$emptyStateText}}@endif</option> @endif
        @foreach ($records as $value => $record)
            <option value="{{$value}}" @if(!empty($selected)) {{  $selected == $value ? 'selected' : '' }}@endif>{{ $record }}</option>
        @endforeach
    </select>
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert" style="display:block;">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
