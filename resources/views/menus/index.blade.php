@extends('menus.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.menus_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success create-new" href="{{ route('menus.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_menu')</a>
            </div>
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
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-9 col-md-6 col-lg-7 py-3 title">
                    <a href="{{ route('menus.edit',$menu->id) }}">{{ $menu->name }}</a>
                </div>
                <div class="col-3 col-md-3 col-lg-3 py-3 code">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-2" data-original-title="@lang('general.code')"></i>
                    {{ $menu->code }} 
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('menus.destroy',$menu->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('menus.edit',$menu->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
                
            </div>
        @endforeach    
    </div>


    {!! $menus->links() !!}


@endsection
