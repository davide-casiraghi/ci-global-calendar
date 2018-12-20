@extends('events.layout')

@section('javascript-document-ready')
    @parent
    {{-- End date update after start date has changed, and doesn't allow to select a date before the start --}}
    $("input[name='startDate']").change(function(){
        var startDate = $("input[name='startDate']").val();
        $("input[name='endDate']").datepicker("setDate", startDate);
        $("input[name='endDate']").datepicker('setStartDate', startDate);
    });
@stop

@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_event')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.title'),
                      'name' => 'title',
                      'placeholder' => 'Event title',
                      'value' => old('title')
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' =>  __('views.created_by'), 
                          'name' => 'created_by',
                          'placeholder' => __('views.select_owner'),
                          'records' => $users
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => __('views.category'),
                      'name' => 'category_id',
                      'placeholder' => __('views.select_category'),
                      'records' => $eventCategories
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.event.select-event-status')
            </div>
            <div class="col-12">
                @include('partials.forms.alert', [
                	'text' => __('views.please_insert_english_translation'),
                	'style' => 'alert-warning',
                ])
                @include('partials.forms.textarea', [
                      'title' =>  __('general.description'),
                      'name' => 'description',
                      'placeholder' => 'Event description',
                      'value' => old('description')
                ])
            </div>
        </div>

        @include('partials.forms.event.select-event-teacher')
        @include('partials.forms.event.select-event-organizer')
        @include('partials.forms.event.select-event-venue')

        <div class="row">
            <div class="col-12">
                <legend>@lang('views.start_end_duration')</legend>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                @include('partials.forms.input-date', [
                      'title' =>  __('views.date_start'),
                      'name' => 'startDate',
                      'placeholder' => __('views.select_date'),
                      'value' => old('startDate')
                ])
            </div>

            <div class="col-6">
                @include('partials.forms.input-time', [
                      'title' =>  __('views.time_start'),
                      'name' => 'time_start',
                      'placeholder' => __('views.select_time'),
                      'value' => '6:00 PM'
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                @include('partials.forms.input-date', [
                      'title' =>  __('views.date_end'),
                      'name' => 'endDate',
                      'placeholder' => __('views.select_date'),
                      'value' => old('endDate')
                ])
            </div>
            <div class="col-6">
                @include('partials.forms.input-time', [
                      'title' =>  __('views.time_end'),
                      'name' => 'time_end',
                      'placeholder' => __('views.select_time'),
                      'value' => '8:00 PM'
                ])
            </div>
        </div>

        @include('partials.forms.event.repeat-event')

        <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' =>  __('views.facebook_event'),
                      'name' => 'facebook_event_link',
                      'placeholder' => 'https://www.facebook.com/events/...'
                      'value' => old('facebook_event_link')
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.event_url'),
                      'name' => 'website_event_link',
                      'placeholder' => 'https://www...',
                      'value' => old('website_event_link')
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'events.index'  
        ])

    </form>

@endsection
