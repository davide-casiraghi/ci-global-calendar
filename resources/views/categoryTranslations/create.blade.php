@extends('categoryTranslations.layout')

@section('content')
    <div class="container max-w-md px-0">
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

        <form action="{{ route('categoryTranslations.store') }}" method="POST">
            @csrf

                @include('partials.forms.input-hidden', [
                      'name' => 'category_id',
                      'value' => $categoryId,
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
                        'placeholder' => 'Category name',
                        'value' => old('name'),
                    ])
                </div>
                
                <div class="col-12">
                    @include('partials.forms.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'value' => old('description')
                    ])
                </div>
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'categories.index'  
            ])

        </form>
    </div>

@endsection
