@extends('categories.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-6">
                <h3>@lang('views.edit_category')</h3>
            </div>
            <div class="col-12 col-sm-6 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
            'style' => 'alert-danger',
        ])

        <form action="{{ route('categories.update',$category->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => 'Category name',
                          'value' => $category->translate('en')->name,
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'value' => $category->translate('en')->description,
                          'required' => false,
                    ])
                </div>
            </div>
            
            @include('laravel-form-partials::buttons-back-submit', [
                'route' => 'categories.index'  
            ])


        </form>
    </div>

@endsection
