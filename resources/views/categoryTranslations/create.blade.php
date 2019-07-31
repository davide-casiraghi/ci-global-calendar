@extends('categoryTranslations.layout')

@section('content')
    <div class="container max-w-md px-0">
        <div class="row py-4">
            <div class="col-12 col-sm-9">
                <h4>@lang('views.add_new_translation')</h4>
            </div>
            <div class="col-12 col-sm-3 text-right">
                <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('categoryTranslations.store') }}" method="POST">
            @csrf

                @include('laravel-form-partials::input-hidden', [
                      'name' => 'category_id',
                      'value' => $categoryId,
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
                        'placeholder' => 'Category name',
                        'value' => old('name'),
                        'required' => true,
                    ])
                </div>
                
                <div class="col-12">
                    @include('partials.forms.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'value' => old('description'),
                          'required' => false,
                    ])
                </div>
            </div>

            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('partials.forms.buttons-back-submit', [
                        'route' => 'categories.index'  
                    ])
                </div>
            </div>

        </form>
    </div>

@endsection
