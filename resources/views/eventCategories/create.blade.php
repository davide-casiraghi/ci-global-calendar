@extends('eventCategories.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-3">
            <div class="col-12 col-sm-8">
                <h3>@lang('views.add_new_event_category')</h3>
            </div>
            <div class="col-12 col-sm-4 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('partials.forms.error-management', [
          'style' => 'alert-danger',
        ])

        <form action="{{ route('eventCategories.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => 'Event category name'
                    ])
                </div>
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'eventCategories.index'  
            ])

        </form>
    </div>

@endsection
