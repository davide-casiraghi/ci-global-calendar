@extends('menus.layout')


@section('content')
    <div class="container max-w-md px-0">
        
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>@lang('views.menus_management')</h3>
            </div>
            <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('menus.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_menu')</a>
            </div>
        </div>
        

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        
        {{-- List of menus --}}
        <div class="menusList my-4 v-sortable">
            @foreach ($menus as $menu)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    <div class="col-12 py-1 title">
                        <h5 class="darkest-gray">{{ $menu->name }}</h5>
                    </div>
                    
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('menus.destroy',$menu->id) }}" method="POST">
                            <a class="btn btn-primary float-right" href="{{ route('menus.edit',$menu->id) }}">@lang('views.edit')</a>
                            <a class="btn btn-info float-right mr-2" href="{{ route('menuItemsIndex', $menu->id) }}"><i class="far fa-bars"></i> @lang('views.menu_items')</a>
                            
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                        </form>
                    </div>
                </div>
                
                
            @endforeach    
        </div>
    </div>

@endsection
