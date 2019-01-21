{{--
    SELECT Dropdown that use bootstrap select - https://developer.snapappointments.com/bootstrap-select/

    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when nothing is selected 
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

<div class="form-group">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}</label>@endif
    <select name="{{ $name }}" id="{{ $name }}" class="selectpicker" data-live-search="{{ $liveSearch }}" title="{{$placeholder}}">
        @foreach ($records as $value => $record)
            <option value="{{$value}}" @if(!empty($seleted)) {{  $seleted == $value ? 'selected' : '' }}@endif>{{ $record }}</option>
        @endforeach
    </select>
</div>
