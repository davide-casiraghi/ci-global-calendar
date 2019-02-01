@foreach($items as $item)
    @if($item->hasParent())
        {{-- Element of submenu --}}
        <li @if($item->hasChildren()) class="dropdown" @endif>
    @else
        {{-- Element of main menu --}}
        <li @if($item->hasChildren()) class="nav-item dropdown" @else class="nav-item" @endif>
    @endif
        @if($item->hasParent())
            <a @if($item->hasChildren()) class="dropdown-item has-submenu" @else class="dropdown-item" @endif href="{!! $item->url() !!}">{!! $item->title !!} </a>
        @else
            <a @if($item->hasChildren()) class="nav-link has-submenu" @else class="nav-link" @endif href="{!! $item->url() !!}">{!! $item->title !!} </a>
        @endif


      @if($item->hasChildren())
        <ul class="dropdown-menu">
              @include('menus.nav.nav-items', ['items' => $item->children()])
        </ul>
      @endif

    </li>
@endforeach

{{-- @if (count($menu_item->children ) > 0)
    <li class='nav-item dropdown'>
@else
   <li class='nav-item'>
@endif --}}
