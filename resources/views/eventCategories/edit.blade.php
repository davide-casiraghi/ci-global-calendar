@extends('eventCategories.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-3">
            <div class="col-12 col-sm-6">
                <h3>@lang('views.edit_event_category')</h3>
            </div>
            <div class="col-12 col-sm-6 text-right">
                <span class="badge badge-secondary">English</span>
            </div>
        </div>

        @include('partials.forms.error-management', [
          'style' => 'alert-danger',
        ])

        <form action="{{ route('eventCategories.update', $eventCategory->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => 'Event category name',
                          'value' => $eventCategory->translate('en')->name
                    ])
                </div>
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'eventCategories.index'  
            ])

        </form>
    </div>

@endsection
