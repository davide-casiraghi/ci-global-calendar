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
                    'title' => __('views.menu_id'),
                    'name' => 'menu_id',
                    'placeholder' => __('views.menu_id'),
                    'records' => $menu,
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
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.menu_item_type'):</strong>
                    <select name="type" class="selectpicker" title="Route or Url">
                        <option value="1" {{'selected'}}>Route</option>
                        <option value="2">Url</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_route'),
                      'name' => 'route',
                      'placeholder' => 'Route',
                      'value' => old('route')
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Url',
                      'name' => 'url',
                      'placeholder' => 'The relative url - eg: /post/about',
                      'value' => old('url')
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_font_awesome_class'),
                      'name' => 'font_awesome_class',
                      'placeholder' => 'Font awesome icon class',
                      'value' => old('font_awesome_class')
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.checkbox', [
                      'name' => 'hide_name',
                      'description' => __('views.menu_item_hide_name'),
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_lang_string'),
                      'name' => 'lang_string',
                      'placeholder' => 'The one in resouces/lang/en - eg. menu.about',
                      'value' => old('lang_string')
                ])
            </div>
            
            
            
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menuItems.index'  
        ])

    </form>

@endsection
