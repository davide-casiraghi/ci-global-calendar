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
                @include('partials.forms.select-menu-items-parent', [
                    'title' => __('views.parent_menu_item'),
                    'name' => 'parent_item_id',
                    'placeholder' => __('views.parent_menu_item'),
                    'records' => $menuItemsTree,
                    'seleted' => $menuItem->parent_item_id,
                    'liveSearch' => 'false',
                    'mobileNativeMenu' => true,
                    'item_id' => $menuItem->id,
                ])
            </div>
            
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.menu_item_type'):</strong>
                    <select name="type" class="selectpicker" title="Route or Url">
                        <option value="1" @if(empty($menuItem->type)) {{'selected'}} @endif @if(!empty($menuItem->type)) {{  $menuItem->type == '1' ? 'selected' : '' }} @endif>Route</option>
                        <option value="2" @if(!empty($menuItem->type)) {{  $menuItem->type == '2' ? 'selected' : '' }} @endif>Url</option>
                        <option value="3" @if(!empty($menuItem->type)) {{  $menuItem->type == '3' ? 'selected' : '' }} @endif>System - User Profile</option>
                        <option value="4" @if(!empty($menuItem->type)) {{  $menuItem->type == '4' ? 'selected' : '' }} @endif>System - Logout</option>    
                    </select>
                </div>
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
                      'title' => 'Url',
                      'name' => 'url',
                      'placeholder' => 'The relative url - eg: /post/about',
                      'value' => $menuItem->url,
                      'hide' => true,
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.menu_item_access'):</strong>
                    <select name="access" class="selectpicker" title="Access">
                        <option value="1" @if(empty($menuItem->access)) {{'selected'}} @endif @if(!empty($menuItem->access)) {{  $menuItem->access == '1' ? 'selected' : '' }} @endif>Public</option>
                        <option value="2" @if(!empty($menuItem->access)) {{  $menuItem->access == '2' ? 'selected' : '' }} @endif>Guest</option>
                        <option value="3" @if(!empty($menuItem->access)) {{  $menuItem->access == '3' ? 'selected' : '' }} @endif>Manager</option>
                        <option value="4" @if(!empty($menuItem->access)) {{  $menuItem->access == '4' ? 'selected' : '' }} @endif>Administrator</option>
                        <option value="5" @if(!empty($menuItem->access)) {{  $menuItem->access == '5' ? 'selected' : '' }} @endif>Super Administrator</option>   
                    </select>
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.select-menu-items-order', [
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
                      'title' => __('views.menu_item_font_awesome_class'),
                      'name' => 'font_awesome_class',
                      'placeholder' => __('views.menu_item_font_awesome_class'),
                      'value' => $menuItem->font_awesome_class
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.checkbox', [
                      'name' => 'hide_name',
                      'description' => __('views.menu_item_hide_name'),
                      'value' => $menuItem->hide_name
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
            'route' => 'menuItemsIndex',
            'routeParameter'  => $menuItem->menu_id,
        ])

    </form>

@endsection
