@foreach($items as $item)
    
    {{-- Get the links --}}
    @switch($item->type)
        @case(1) {{-- ROUTE --}} 
            @php ($url = route($item->route) )
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
            @if ($item->lang_string)
                @php ($itemName = __($item->lang_string))
            @else
                @php ($itemName = $item->name)
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
                     @include('menus.nav.nav-items', ['items' => $item->children])
               </ul>
             @endif
     @endif
    
@endforeach
