@extends('events.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit event</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management')

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
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-category')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-status')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.textarea-event-description')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-teacher')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-organizer')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-venue')
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
                      'name' => 'faecbook',
                      'placeholder' => 'https://www.facebook.com/events/...',
                      'value' => $event->facebook_link
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Event URL',
                      'name' => 'faecbook',
                      'placeholder' => 'https://www.facebook.com/events/...',
                      'value' => $event->website_link
                ])
            </div>

        </div>




        {{--@include('partials.forms.image-event')--}}

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('events.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


        <!--<input type="hidden" name="author_id" value="1">
        <input type="hidden" name="image" value="3">-->


    </form>

@endsection
