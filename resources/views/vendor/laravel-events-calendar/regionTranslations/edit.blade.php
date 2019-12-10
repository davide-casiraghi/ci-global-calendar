@extends('laravel-events-calendar::regionTranslations.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>@lang('laravel-events-calendar::general.edit_translation')</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-form-partials::error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('regionTranslations.update') }}" method="POST">
        @csrf
        @method('PUT')

            @include('laravel-form-partials::input-hidden', [
                  'name' => 'region_translation_id',
                  'value' => $regionTranslation->id
            ])

            @include('laravel-form-partials::input-hidden', [
                  'name' => 'event_region_id',
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
                    'value' => $regionTranslation->name,
                    'required' => true,
                ])
            </div>
            
        </div>
        
        <div class="row mt-2">  
            <div class="col-12 action">
                @include('laravel-form-partials::buttons-back-submit', [
                    'route' => 'regions.index'  
                ])
    </form>

                <form action="{{ route('regionTranslations.destroy',$regionTranslation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pl-0">@lang('laravel-events-calendar::general.delete_translation')</button>
                </form>
            </div>
        </div>
        
@endsection
