@extends('menuItems.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_menu_item')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('menuItems.update',$menuItem->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'menu item Name',
                      'value' => $menuItem->name
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.menu_id'),
                    'name' => 'menu_id',
                    'placeholder' => __('views.menu_id'),
                    'records' => $menu,
                    'seleted' => $menuItem->menu_id,
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.parent_menu_item'),
                    'name' => 'parent_item_id',
                    'placeholder' => __('views.parent_menu_item'),
                    'records' => $menuItems,
                    'seleted' => $menuItem->parent_item_id,
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.menu_item_order'),
                    'name' => 'order',
                    'placeholder' => __('views.menu_item_order'),
                    'records' => $menuItemsSameMenuAndLevel,
                    'seleted' => $menuItem->id,
                    'tooltip' => "The menu item will be placed in the menu after the selected menu item.",
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_type'),
                      'name' => 'type',
                      'placeholder' => 'Route or Url',
                      'value' => $menuItem->type
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Url',
                      'name' => 'url',
                      'placeholder' => 'The relative url - eg: /post/about',
                      'value' => $menuItem->url
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_route'),
                      'name' => 'route',
                      'placeholder' => 'Route',
                      'value' => $menuItem->route
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_font_awesome_class'),
                      'name' => 'font_awesome_class',
                      'placeholder' => 'Font awesome icon class',
                      'value' => $menuItem->font_awesome_class
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_lang_string'),
                      'name' => 'lang_string',
                      'placeholder' => 'The one in resouces/lang/en - eg. menu.about',
                      'value' => $menuItem->lang_string
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menuItems.index'  
        ])

    </form>

@endsection
