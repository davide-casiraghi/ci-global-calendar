@extends('categories.layout')


@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.edit_category')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">English</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
        'style' => 'alert-danger',
    ])

    <form action="{{ route('categories.update',$category->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Category name',
                      'value' => $category->translate('en')->name
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => __('general.description'),
                      'name' => 'description',
                      'placeholder' => 'Description',
                      'value' => $category->translate('en')->description
                ])
            </div>
        </div>
        
        @include('partials.forms.buttons-back-submit', [
            'route' => 'categories.index'  
        ])


    </form>


@endsection
