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
        - $item_id: int - the id of the item edited
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
        <label for="{{ $name }}">{{ $title }}</label>
        @if(!empty($tooltip))<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $tooltip }}"></i>@endif
    @endif
    <select name="{{ $name }}" id="{{ $name }}" class="selectpicker" data-live-search="{{ $liveSearch }}" title="{{$placeholder}}">
        <option value="">- Root</option>
        
        {{-- Render items level 0 --}}
            @foreach ($records as $value => $record)    
                @if (empty($item_id) || $record->id != $item_id) {{-- Show all if in create view or hide the same item in the edit view --}}
                    <option value="{{$record->id}}" @if(!empty($seleted)) {{  $seleted == $record->id ? 'selected' : '' }}@endif>-- {{ $record->name }}</option>
                @endif
                    
                {{-- Render items level 1 --}}
                    @if (!empty($record->children))
                        @foreach ($record->children as $key => $subItem)
                            
                            @if (empty($item_id) || $subItem->id != $item_id) {{-- Show all if in create view or hide the same item in the edit view --}}
                                <option value="{{$subItem->id}}" @if(!empty($seleted)) {{  $seleted == $subItem->id ? 'selected' : '' }}@endif>---- {{ $subItem->name }}</option>
                            @endif
                        @endforeach
                    @endif
                    
            @endforeach
        
    </select>
</div>
