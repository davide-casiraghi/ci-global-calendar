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
<div class="routeFields">
    <div class="form-group {{ $name }}">
        @if(!empty($title))
            <label for="{{ $name }}">{{ $title }}</label>
            @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
        @endif
        <select name="{{ $name }}" id="{{ $name }}" class="selectpicker" data-live-search="{{ $liveSearch }}" title="{{$placeholder}}">
            @foreach ($records as $value => $record)
                <option value="{{ $record }}" @if(!empty($seleted)) {{  $seleted == $record ? 'selected' : '' }}@endif>{{ $record }}</option>
            @endforeach
        </select>
    </div>
    <div class="row">
        <div class="col-4">
            @include('laravel-form-partials::input', [
                  'title' => __('views.param_1_Name'),
                  'name' => 'route_param_name_1',
                  'placeholder' => '',
                  'value' =>  $route_param_name_1,
                  'required' => false,
            ])
            @include('laravel-form-partials::input', [
                  'title' => __('views.param_1_Value'),
                  'name' => 'route_param_value_1',
                  'placeholder' => '',
                  'value' => $route_param_value_1,
                  'required' => false,
            ])
        </div>
        <div class="col-4">
            @include('laravel-form-partials::input', [
                  'title' => __('views.param_2_Name'),
                  'name' => 'route_param_name_2',
                  'placeholder' => '',
                  'value' => $route_param_name_2,
                  'required' => false,
            ])
            @include('laravel-form-partials::input', [
                  'title' => __('views.param_2_Value'),
                  'name' => 'route_param_value_2',
                  'placeholder' => '',
                  'value' => $route_param_value_2,
                  'required' => false,
            ])
        </div>
        <div class="col-4">
            @include('laravel-form-partials::input', [
                  'title' => __('views.param_3_Name'),
                  'name' => 'route_param_name_3',
                  'placeholder' => '',
                  'value' => $route_param_name_3,
                  'required' => false,
            ])
            @include('laravel-form-partials::input', [
                  'title' => __('views.param_3_Value'),
                  'name' => 'route_param_value_3',
                  'placeholder' => '',
                  'value' => $route_param_value_3,
                  'required' => false,
            ])
        </div>
    </div>
</div>
