@extends('laravel-quick-menus::menuItemTranslations.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>@lang('laravel-quick-menus::menuItem.edit_translation')</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-quick-menus::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('menuItemTranslations.update',$menuItemId) }}" method="POST">
        @csrf
        @method('PUT')

            @include('laravel-quick-menus::partials.input-hidden', [
                  'name' => 'menu_item_translation_id',
                  'value' => $menuItemTranslation->id
            ])
            
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
                    'value' => $menuItemTranslation->name,
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
    </form>

                <form action="{{ route('menuItemTranslations.destroy',[$menuItemTranslation->id, $selectedMenuId]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pl-0">@lang('laravel-quick-menus::menuItem.delete_translation')</button>
                </form>
            </div>
        </div>
        

@endsection
