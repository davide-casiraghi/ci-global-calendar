@extends('events.layout')

@section('content')
    <div class="row">
        <div class="col-sm-10 margin-tb">
            <div class="pull-left">
                <h2>Edit event</h2>
            </div>
        </div>
        <div class="col-sm-2 text-right">
            <form action="{{ route('events.destroy',$event->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete event</button>
            </form>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('events.update',$event->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Title',
                      'name' => 'title',
                      'placeholder' => 'Event title',
                      'value' => $event->title
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @include('partials.forms.select', [
                          'title' => 'Created by',
                          'name' => 'created_by',
                          'placeholder' => 'Select owner',
                          'records' => $users,
                          'seleted' => $event->created_by
                    ])
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select', [
                      'title' => 'Category',
                      'name' => 'category_id',
                      'placeholder' => 'Select category',
                      'records' => $eventCategories,
                      'seleted' => $event->category_id
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.event.select-event-status')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.textarea', [
                      'title' => 'Description',
                      'name' => 'description',
                      'placeholder' => 'Event description',
                      'value' => $event->description
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.event.select-event-teacher')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.event.select-event-organizer')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.event.select-event-venue')
            </div>
        </div>

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
                {{--@include('partials.forms.input-time-start')--}}

                @include('partials.forms.input-time', [
                      'title' => 'Time Start',
                      'name' => 'time_start',
                      'placeholder' => 'select time',
                      'value' => $dateTime['timeStart']
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-date-end')
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                {{--@include('partials.forms.input-time-end')--}}
                @include('partials.forms.input-time', [
                      'title' => 'Time End',
                      'name' => 'time_end',
                      'placeholder' => 'select time',
                      'value' => $dateTime['timeEnd']
                ])
            </div>
        </div>

        @include('partials.repeat-event', [
              'event' => $event
        ])

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Facebook event',
                      'name' => 'facebook_event_link',
                      'placeholder' => 'https://www.facebook.com/events/...',
                      'value' => $event->facebook_event_link
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Event URL',
                      'name' => 'website_event_link',
                      'placeholder' => 'https://www...',
                      'value' => $event->website_event_link
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
