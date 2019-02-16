@extends('eventCategoryTranslations.layout')

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

    <form action="{{ route('eventCategoryTranslations.update') }}" method="POST">
        @csrf
        @method('PUT')

            @include('partials.forms.input-hidden', [
                  'name' => 'event_category_translation_id',
                  'value' => $eventCategoryTranslation->id
            ])

            @include('partials.forms.input-hidden', [
                  'name' => 'event_category_id',
                  'value' => $eventCategoryId,
            ])
            @include('partials.forms.input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Event Category name',
                    'value' => $eventCategoryTranslation->name,
                ])
            </div>
            
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'eventCategories.index'  
        ])

    </form>

@endsection
