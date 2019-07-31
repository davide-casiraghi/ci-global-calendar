@extends('laravel-events-calendar::eventCategories.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-8">
                <h4>@lang('laravel-events-calendar::eventCategory.add_new_event_category')</h4>
            </div>
            <div class="col-12 col-sm-4 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
          'style' => 'alert-danger',
        ])

        <form action="{{ route('eventCategories.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('laravel-events-calendar::general.name'),
                          'name' => 'name',
                          'placeholder' => 'Event category name',
                          'required' => true,
                    ])
                </div>
            </div>

            @include('laravel-form-partials::buttons-back-submit', [
                'route' => 'eventCategories.index'  
            ])

        </form>
    </div>

@endsection
