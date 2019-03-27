@extends('categories.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-10">
                <h3>@lang('views.add_new_category')</h3>
            </div>
            <div class="col-12 col-sm-2 text-right">
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
                          'placeholder' => 'Category name',
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => 'Description',
                          'required' => false,
                    ])
                </div>
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'categories.index'  
            ])

        </form>
    </div>
@endsection
