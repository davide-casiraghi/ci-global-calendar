@extends('laravel-quick-menus::menuItemTranslations.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>@lang('laravel-quick-menus::menuItem.add_new_translation')</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-quick-menus::partials.error-management', [
          'style' => 'alert-danger',
    ])

    
    <form action="{{ route('menuItemTranslations.store') }}" method="POST">
        @csrf

            @include('laravel-quick-menus::partials.input-hidden', [
                  'name' => 'menu_item_id',
                  'value' => $menuItemId,
            ])
            @include('laravel-quick-menus::partials.input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])
            @include('laravel-quick-menus::partials.input-hidden', [
                  'name' => 'selected_menu_id',
                  'value' => $selectedMenuId,
            ])

         <div class="row">
            <div class="col-12">
                @include('laravel-quick-menus::partials.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Menu item name',
                    'value' => old('name'),
                    'required' => true,
                ])
            </div>
        </div>

        <div class="row mt-2">  
            <div class="col-12 action">
                @include('laravel-quick-menus::partials.buttons-back-submit', [
                    'route' => 'menuItemsIndex',
                    'routeParameter' => $selectedMenuId,
                ])
            </div>
        </div>

    </form>

@endsection
