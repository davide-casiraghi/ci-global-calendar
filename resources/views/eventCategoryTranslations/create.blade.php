@extends('eventCategoryTranslations.layout')

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.add_new_translation')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('eventCategoryTranslations.store') }}" method="POST">
        @csrf

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
                    'value' => old('name'),
                ])
            </div>
            
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'eventCategories.index'  
        ])

    </form>

@endsection
