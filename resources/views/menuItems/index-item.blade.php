
{{--

    RENDER THE MENU ITEM - and the sub items 
    It render also the sub items calling itself in a recursive way

    PARAMETERS:
        - $menuItem: object - the menu item
        - $level: int - the menu item depth in the tree
        - $index: used to decide the color of the item background
        - $countriesAvailableForTranslations: language tags of the countries available for translations
--}}

@php ($paddingLeft = $level*2-1)

<div class="row py-1 border-bottom">
    <div class="col-10 col-md-8 pt-2 order-1" style="padding-left:{{$paddingLeft}}rem">
        <a href="{{ route('menuItems.edit',$menuItem->id) }}">
            @if(!empty($menuItem->font_awesome_class))<i class="{{ $menuItem->font_awesome_class }}"></i> @endif
            @if(empty($menuItem->hide_name)){{ $menuItem->name }} @endif
        </a>
        @if(!empty($menuItem->access)) <span class="text-secondary">- {{App\MenuItem::getAccessName($menuItem->access)}}</span>@endif
    </div>
    <div class="col-12 col-md-3 pt-2 pt-md-1 order-3 order-md-2 text-right">
        @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
            @if($menuItem->hasTranslation($key))
                <a href="/menuItemTranslations/{{ $menuItem->id }}/{{ $key }}/{{$selectedMenuId}}/edit" class="bg-success text-white d-inline-block p-1 mb-1">{{$key}}</a>
            @else
                <a href="/menuItemTranslations/{{ $menuItem->id }}/{{ $key }}/{{$selectedMenuId}}/create" class="bg-secondary text-white d-inline-block p-1 mb-1">{{$key}}</a>
            @endif
        @endforeach
    </div>
    <div class="col-2 col-md-1 order-2 order-md-3">
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
