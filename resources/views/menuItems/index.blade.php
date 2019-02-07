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
    {{--<ul-list-draggable :items_input="{{ json_encode($menuItemsTree) }}" :locale="{{ json_encode(app()->getLocale()) }}" ></ul-list-draggable> --}}
    
    
    <div class="menuItemsList my-4">
        @foreach ($menuItemsTree as $menuItem)
            <div class="row pt-2 pb-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }} border-bottom">
                <div class="col-10">
                    <a href="{{ route('menuItems.edit',$menuItem->id) }}">{{ $menuItem->name }}</a>
                </div>
                <div class="col-2">
                    <form action="{{ route('menuItems.destroy',$menuItem->id) }}" method="POST">
                        
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
            
            {{-- Sub items --}}
            @if (!empty($menuItem->children))
                @foreach ($menuItem->children as $subItem)
                    <div class="row border-bottom pt-2 pb-1">
                        <div class="col-10 pl-5">
                            <a href="{{ route('menuItems.edit',$subItem->id) }}">{{ $subItem->name }}</a>
                        </div>
                        <div class="col-2">
                            <form action="{{ route('menuItems.destroy',$subItem->id) }}" method="POST">
                                
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                    
                    {{-- Sub sub items --}}
                    @if (!empty($subItem->children))
                        @foreach ($subItem->children as $subSubItem)
                            <div class="row border-bottom pt-2 pb-1">
                                <div class="col-10" style="padding-left: 5rem;">
                                    <a href="{{ route('menuItems.edit',$subSubItem->id) }}">{{ $subSubItem->name }}</a>
                                </div>
                                <div class="col-2">
                                    <form action="{{ route('menuItems.destroy',$subSubItem->id) }}" method="POST">
                                        
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach    
            @endif
        @endforeach    
    </div>

@endsection
