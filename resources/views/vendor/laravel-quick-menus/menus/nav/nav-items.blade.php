@foreach($items as $item)
    
    {{-- Get the links --}}
    @switch($item->type)
        @case(1) {{-- ROUTE --}} 
            @php 
                $routeParams = array();
                //array_push($routeParams, $item->param_1, $item->param_2, $item->param_3);
                $routeParams[$item->route_param_name_1] = $item->route_param_value_1;
                $routeParams[$item->route_param_name_2] = $item->route_param_value_2;
                $routeParams[$item->route_param_name_3] = $item->route_param_value_3;
                $url = route($item->route,$routeParams);
            @endphp
        @break

        @case(2) {{-- URL --}}
            @php ($url = $item->url)
        @break
        
        @case(3) {{-- System - User Profile --}}            
            @if(Auth::user())
                @php ($url = route('users.edit', ['id' => Auth::user()->id]))
            @else
                @php ($url = "")
            @endif    
        @break
        
        @case(4) {{-- System - Logout --}}
            @php ($url = "#")
            @php ($onclick = "event.preventDefault(); document.getElementById('logout-form').submit();")
        @break
        
    @endswitch
    
    
    
    @if($item->authorized()) {{-- Check item access <-> User group --}}
        {{-- Get item name --}}
            @if ($item->name)
                @php ($itemName = $item->name)
            @else
                @php ($itemName = $item->translate('en')->name)
            @endif
            
        {{-- Render item --}}
            @if(!empty($item->parent_item_id))
               {{-- Element of submenu --}}
               <li @if(!empty($item->children)) class="dropdown" @endif>
            @else
               {{-- Element of main menu --}}
               <li @if(!empty($item->children)) class="nav-item dropdown" @else class="nav-item" @endif>
            @endif

            @if(!empty($item->parent_item_id))
               <a @if(!empty($item->children)) class="dropdown-item has-submenu" @else class="dropdown-item" @endif href="{!! $url !!}" @if(!empty($onclick)) onclick="{{$onclick}}" @endif)>
                   @if(!empty($item->font_awesome_class))<i class="{{$item->font_awesome_class}}"></i>@endif @if(empty($item->hide_name)){{$itemName}}@endif
               </a>
            @else
               <a @if(!empty($item->children)) class="nav-link has-submenu" @else class="nav-link" @endif href="{!! $url !!}">
                   @if(!empty($item->font_awesome_class))<i class="{{$item->font_awesome_class}}"></i>@endif @if(empty($item->hide_name)){{$itemName}}@endif
               </a>
            @endif

        {{-- Sub items --}}
             @if(!empty($item->children))
               <ul class="dropdown-menu">
                     @include('laravel-quick-menus::menus.nav.nav-items', ['items' => $item->children])
               </ul>
             @endif
     @endif
    
@endforeach
