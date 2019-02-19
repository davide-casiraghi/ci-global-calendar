@extends('categories.layout')


@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h3>@lang('views.add_new_category')</h3>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">English</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Category name'
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => __('general.description'),
                      'name' => 'description',
                      'placeholder' => 'Description'
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'categories.index'  
        ])

    </form>


@endsection
