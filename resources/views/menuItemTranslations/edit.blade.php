@extends('menuItemTranslations.layout')

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.edit_translation')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('menuItemTranslations.update',$menuItemId) }}" method="POST">
        @csrf
        @method('PUT')

            @include('partials.forms.input-hidden', [
                  'name' => 'menu_item_translation_id',
                  'value' => $menuItemTranslation->id
            ])
            
            @include('partials.forms.input-hidden', [
                  'name' => 'menu_item_id',
                  'value' => $menuItemId,
            ])
            @include('partials.forms.input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])
            @include('partials.forms.input-hidden', [
                  'name' => 'selected_menu_id',
                  'value' => $selectedMenuId,
            ])

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Menu item name',
                    'value' => $menuItemTranslation->name,
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menuItemsIndex',
            'routeParameter' => $selectedMenuId,
        ])

    </form>

@endsection
