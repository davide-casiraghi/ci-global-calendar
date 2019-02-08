@foreach($items as $item)
    
    {{-- Get the links --}}
    @switch($item->type)
        @case(1) {{-- ROUTE --}} {{--$item->route--}}
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
    
    
    
    @if(!empty($item->parent_item_id))
       {{-- Element of submenu --}}
       <li @if(!empty($item->children)) class="dropdown" @endif>
   @else
       {{-- Element of main menu --}}
       <li @if(!empty($item->children)) class="nav-item dropdown" @else class="nav-item" @endif>
   @endif

   @if(!empty($item->parent_item_id))
       <a @if(!empty($item->children)) class="dropdown-item has-submenu" @else class="dropdown-item" @endif href="{!! $url !!}" @if(!empty($onclick)) onclick="{{$onclick}}" @endif)>
           @if(!empty($item->font_awesome_class))<i class="{{$item->font_awesome_class}}"></i>@endif @if(empty($item->hide_name)){{$item->name}}@endif
       </a>
   @else
       <a @if(!empty($item->children)) class="nav-link has-submenu" @else class="nav-link" @endif href="{!! $url !!}">
           @if(!empty($item->font_awesome_class))<i class="{{$item->font_awesome_class}}"></i>@endif @if(empty($item->hide_name)){{$item->name}}@endif
       </a>
   @endif


     @if(!empty($item->children))
       <ul class="dropdown-menu">
             @include('menus.nav.nav-items', ['items' => $item->children])
       </ul>
     @endif
    
    
    
    
    {{--
    <li class="nav-item @if(!empty($item->children))dropdown @endif"> 
        <a class="nav-link @if(!empty($item->children))has-submenu @endif" href="{{$item->url}}">
            @if(!empty($item->font_awesome_class))<i class="{{$item->font_awesome_class}}"></i>@endif {{$item->name}}
            @if(!empty($item->children))<span class="sub-arrow"></span> @endif
        </a>
        @if(!empty($item->children))
            <ul class="dropdown-menu">
             @include('menus.nav.nav-items', ['items' => $item->children])
            </ul>
        @endif
        
    </li>--}}
@endforeach

{{-- @if (count($menu_item->children ) > 0)
    <li class='nav-item dropdown'>
@else
   <li class='nav-item'>
@endif --}}


{{--<li class="nav-item">
                        <a class="nav-link" href="/"><i class="fa fa-home"></i> Home </a>
        

      
    </li>--}}
