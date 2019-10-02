@extends('laravel-events-calendar::regionTranslations.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>@lang('laravel-events-calendar::general.add_new_translation')</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-form-partials::error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('regionTranslations.store') }}" method="POST">
        @csrf

            @include('laravel-form-partials::input-hidden', [
                  'name' => 'region_id',
                  'value' => $regionId,
            ])
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])

         <div class="row">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Region/State name',
                    'value' => old('name'),
                    'required' => true,
                ])
            </div>
            
        </div>

        @include('laravel-form-partials::buttons-back-submit', [
            'route' => 'regions.index'  
        ])

    </form>

@endsection
