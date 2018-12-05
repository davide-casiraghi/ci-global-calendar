@extends('events.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New event</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Title',
                      'name' => 'title',
                      'placeholder' => 'Event title'
                ])

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select', [
                      'title' => 'Category',
                      'name' => 'category_id',
                      'placeholder' => 'Select category',
                      'records' => $eventCategories
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @include('partials.forms.select', [
                          'title' => 'Created by',
                          'name' => 'created_by',
                          'placeholder' => 'Select owner',
                          'records' => $users
                    ])
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.event.select-event-status')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.alert', [
                	'text' => 'Please insert also an english translation of your event below the description, even short.',
                	'style' => 'alert-warning',
                ])
                @include('partials.forms.textarea', [
                      'title' => 'Description',
                      'name' => 'description',
                      'placeholder' => 'Event description',
                ])
            </div>
        </div>

        @include('partials.forms.event.select-event-teacher')

        @include('partials.forms.event.select-event-organizer')

        @include('partials.forms.event.select-event-venue')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <legend>Start, End, Duration</legend>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-date-start')
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-time-start')
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-date-end')
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-time-end')
            </div>
        </div>

        @include('partials.repeat-event')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Facebook event',
                      'name' => 'facebook_event_link',
                      'placeholder' => 'https://www.facebook.com/events/...'
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Event URL',
                      'name' => 'website_event_link',
                      'placeholder' => 'https://www...'
                ])
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('events.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
