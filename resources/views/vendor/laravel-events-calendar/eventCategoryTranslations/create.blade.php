@extends('laravel-events-calendar::eventCategoryTranslations.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>@lang('views.add_new_translation')</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-events-calendar::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('eventCategoryTranslations.store') }}" method="POST">
        @csrf

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
                    'value' => old('name'),
                    'required' => true,
                ])
            </div>
            
        </div>

        @include('laravel-events-calendar::partials.buttons-back-submit', [
            'route' => 'eventCategories.index'  
        ])

    </form>

@endsection
