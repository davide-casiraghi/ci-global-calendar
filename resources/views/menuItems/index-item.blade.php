
{{--

    RENDER THE MENU ITEM - and the sub items 
    It render also the sub items calling itself in a recursive way

    PARAMETERS:
        - $menuItem: object - the menu item
        - $level: int - the menu item depth in the tree
        - $index: used to decide the color of the item background
--}}

@php ($paddingLeft = $level*2-1)

<div class="row py-1 border-bottom">
    <div class="col-10 pt-2" style="padding-left:{{$paddingLeft}}rem">
        <a href="{{ route('menuItems.edit',$menuItem->id) }}">
            @if(!empty($menuItem->font_awesome_class))<i class="{{ $menuItem->font_awesome_class }}"></i> @endif
            @if(empty($menuItem->hide_name)){{ $menuItem->name }} @endif
        </a>
        @if(!empty($menuItem->access)) <span class="text-secondary">- {{App\MenuItem::getAccessName($menuItem->access)}}</span>@endif
    </div>
    <div class="col-2">
        <form action="{{ route('menuItems.destroy',$menuItem->id) }}" method="POST">
            
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
        </form>
    </div>
</div>

{{-- Sub Items (recursive) --}}
@if (!empty($menuItem->children))
    @foreach ($menuItem->children as $menuItemChildren)
        @include('menuItems.index-item', [
            'menuItem' => $menuItemChildren,
            'level' => $level+1,
        ])
    @endforeach
@endif
