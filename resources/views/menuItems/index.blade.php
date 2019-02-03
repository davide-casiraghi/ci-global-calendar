@extends('menuItems.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.menu_items_management')</h2>
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
    <ul-list-draggable :testimonials="{{ json_encode($menuItems) }}"></ul-list-draggable>
    
    
    <div class="menuItemsList my-4">
        @foreach ($menuItems as $menuItem)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-9 col-md-6 col-lg-7 py-3 title">
                    <a href="{{ route('menuItems.edit',$menuItem->id) }}">{{ $menuItem->name }}</a>
                </div>
                {{--<div class="col-3 col-md-3 col-lg-3 py-3 code">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-2" data-original-title="@lang('general.code')"></i>
                    {{ $menuItems->code }} 
                </div>--}}
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('menuItems.destroy',$menuItem->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('menuItems.edit',$menuItem->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
                
            </div>
        @endforeach    
    </div>


    {!! $menuItems->links() !!}


@endsection
