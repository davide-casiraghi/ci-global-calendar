@extends('categoryTranslations.layout')

@section('content')
    <div class="container max-w-md px-0">
        <div class="row py-4">
            <div class="col-12 col-sm-9">
                <h4>@lang('views.edit_translation')</h4>
            </div>
            <div class="col-12 col-sm-3 text-right">
                <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('categoryTranslations.update') }}" method="POST">
            @csrf
            @method('PUT')

                @include('partials.forms.input-hidden', [
                      'name' => 'category_translation_id',
                      'value' => $categoryTranslation->id
                ])

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
                        'value' => $categoryTranslation->name,
                        'required' => true,
                    ])
                </div>
                
                <div class="col-12">
                    @include('partials.forms.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'value' => $categoryTranslation->description,
                          'required' => false,
                    ])
                </div>
            </div>
            
            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('partials.forms.buttons-back-submit', [
                        'route' => 'categories.index'  
                    ])
        </form>

                    <form action="{{ route('categoryTranslations.destroy',$categoryTranslation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link pl-0">@lang('views.delete_translation')</button>
                    </form>
                </div>
            </div>
            
    </div>

@endsection
