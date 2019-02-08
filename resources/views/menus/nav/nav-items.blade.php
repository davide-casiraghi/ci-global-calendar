@foreach($items as $item)
    <li class="nav-item">
        <a class="nav-link" href="{{$item->url}}">
            @if(!empty($item->font_awesome_class))<i class="{{$item->font_awesome_class}}"></i>@endif {{$item->name}}
        </a>
    </li>
@endforeach

{{-- @if (count($menu_item->children ) > 0)
    <li class='nav-item dropdown'>
@else
   <li class='nav-item'>
@endif --}}


{{--<li class="nav-item">
                        <a class="nav-link" href="/"><i class="fa fa-home"></i> Home </a>
        

      
    </li>--}}
