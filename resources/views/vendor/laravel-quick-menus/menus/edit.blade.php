@extends('laravel-quick-menus::menus.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('laravel-quick-menus::menu.edit_menu')</h2>
            </div>
        </div>
    </div>

    @include('laravel-quick-menus::partials.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('menus.update',$menu->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('laravel-quick-menus::partials.input', [
                      'title' => __('laravel-quick-menus::menu.name'),
                      'name' => 'name',
                      'placeholder' => 'menu Name',
                      'value' => $menu->name,
                      'required' => true,
                ])
            </div>
            
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('laravel-quick-menus::menu.menu_position'):</strong>
                    <select name="position" class="selectpicker" title="Position">
                        <option value="1" @if(empty($menu->position)) {{'selected'}} @endif @if(!empty($menu->position)) {{  $menu->position == '1' ? 'selected' : '' }} @endif>Nav - Left (main)</option>
                        <option value="2" @if(!empty($menu->position)) {{  $menu->position == '2' ? 'selected' : '' }} @endif>Nav - Right</option>
                        <option value="3" @if(!empty($menu->position)) {{  $menu->position == '3' ? 'selected' : '' }} @endif>Footer</option>
                        <option value="4" @if(!empty($menu->position)) {{  $menu->position == '4' ? 'selected' : '' }} @endif>Custom 1</option>
                        <option value="5" @if(!empty($menu->position)) {{  $menu->position == '5' ? 'selected' : '' }} @endif>Custom 2</option>
                        <option value="6" @if(!empty($menu->position)) {{  $menu->position == '6' ? 'selected' : '' }} @endif>Custom 3</option>
                    </select>
                </div>
            </div>
            
            
        </div>

        @include('laravel-quick-menus::partials.buttons-back-submit', [
            'route' => 'menus.index'  
        ])

    </form>

@endsection
