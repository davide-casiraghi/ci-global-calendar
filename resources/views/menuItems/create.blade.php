@extends('menuItems.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_menu_item')</h2>
            </div>
        </div>
    </div>

   @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('menuItems.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Menu item name',
                      'value' => old('name')
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.parent_menu_item'),
                    'name' => '	parent_item_id',
                    'placeholder' => __('views.select_parent_menu_item'),
                    'records' => $menuItems,
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menuItems.index'  
        ])

    </form>

@endsection
