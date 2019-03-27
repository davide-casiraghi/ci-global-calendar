@extends('menuItems.layout')

@section('javascript-document-ready')
    @parent
    
    {{-- ON LOAD --}}
        hideShowsControls();

    {{-- ON CHANGE --}}
        $("select[name='type']").change(function(){
            hideShowsControls();
         });
         
     {{-- SHOW/HIDE elements relating with the selected menu item TYPE  --}}
         function hideShowsControls(){
             switch($("select[name='type']").val()) {
                 case "1":
                     $(".form-group.url").hide();
                     $(".form-group.route").show();
                     $(".form-group.route").fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
                 break;
                 case "2":
                     $(".form-group.route").hide();
                     $(".form-group.url").show();
                     $(".form-group.url").fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
                 break;
                 case "3":
                     $(".form-group.route").hide();
                     $(".form-group.url").hide();
                 break;  
             }
         }
     
@stop

@section('content')    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.add_new_menu_item')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">English</span>
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
                      'value' => old('name'),
                      'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.menu_id'),
                    'name' => 'menu_id',
                    'placeholder' => __('views.menu_id'),
                    'records' => $menu,
                    'seleted' => $selectedMenuId,
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select-menu-items-parent', [
                    'title' => __('views.parent_menu_item'),
                    'name' => 'parent_item_id',
                    'placeholder' => __('views.parent_menu_item'),
                    'records' => $menuItemsTree,
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                    'required' => false,
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.menu_item_type')</strong>
                    <select name="type" class="selectpicker" title="Route or Url">
                        <option value="1" {{'selected'}}>Route</option>
                        <option value="2">Url</option>
                        <option value="3">System - User Profile</option>
                        <option value="4">System - Logout</option>
                    </select>
                </div>
            </div>
                        
            {{--<div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_route'),
                      'name' => 'route',
                      'placeholder' => 'Route',
                      'value' => old('route')
                ])
            </div>--}}
            <div class="col-12">
                @include('partials.forms.select-menu-items-route', [
                    'title' => __('views.menu_item_route'),
                    'name' => 'route',
                    'placeholder' => __('views.menu_item_route'),
                    'records' => $routeNames,
                    'liveSearch' => 'true',
                    'mobileNativeMenu' => false,
                    'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Url',
                      'name' => 'url',
                      'placeholder' => 'The relative url - eg: /post/about',
                      'value' => old('url'),
                      'required' => false,
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.menu_item_access')</strong>
                    <select name="access" class="selectpicker" title="Access">
                        <option value="1" {{'selected'}}>Public</option>
                        <option value="2">Guest</option>
                        <option value="3">Manager</option>
                        <option value="4">Administrator</option>
                        <option value="5">Super Administrator</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.menu_item_font_awesome_class'),
                      'name' => 'font_awesome_class',
                      'placeholder' => 'Font awesome icon class',
                      'value' => old('font_awesome_class'),
                      'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.checkbox', [
                      'name' => 'hide_name',
                      'description' => __('views.menu_item_hide_name'),
                      'value' => '',
                      'required' => false,
                ])
            </div>
        </div>
        

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menuItemsIndex',
            'routeParameter' => $selectedMenuId,
        ])

    </form>

@endsection
