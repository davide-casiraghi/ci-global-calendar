@extends('laravel-events-calendar::eventCategoryTranslations.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>@lang('views.edit_translation')</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-events-calendar::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('eventCategoryTranslations.update') }}" method="POST">
        @csrf
        @method('PUT')

            @include('laravel-events-calendar::partials.input-hidden', [
                  'name' => 'event_category_translation_id',
                  'value' => $eventCategoryTranslation->id
            ])

            @include('laravel-events-calendar::partials.input-hidden', [
                  'name' => 'event_category_id',
                  'value' => $eventCategoryId,
            ])
            @include('laravel-events-calendar::partials.input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])

         <div class="row">
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Event Category name',
                    'value' => $eventCategoryTranslation->name,
                    'required' => true,
                ])
            </div>
            
        </div>
        
        <div class="row mt-2">  
            <div class="col-12 action">
                @include('laravel-events-calendar::partials.buttons-back-submit', [
                    'route' => 'eventCategories.index'  
                ])
    </form>

                <form action="{{ route('eventCategoryTranslations.destroy',$eventCategoryTranslation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pl-0">@lang('views.delete_translation')</button>
                </form>
            </div>
        </div>
        
        
        
        
        
        
        
        
        

    

@endsection
