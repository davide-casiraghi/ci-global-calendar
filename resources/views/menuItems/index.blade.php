@extends('menuItems.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.items'): {{$selectedMenuName}}</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success create-new" href="{{ route('menuItems.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_menu_item')</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    
    {{-- List of menus items --}}
    <div class="menuItemsList my-4 alternateColors">
        @foreach ($menuItemsTree as $menuItem)
            @include('menuItems.index-item', [
                'menuItem' => $menuItem,
                'level' => 1,
            ])
        @endforeach    
    </div>

@endsection
