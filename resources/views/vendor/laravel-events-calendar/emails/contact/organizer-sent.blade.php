@extends('laravel-events-calendar::events.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <h2 class="mb-4">@lang('laravel-events-calendar::event.message_sent_to_organizers')</h2>
            @lang('laravel-events-calendar::event.message_sent_to_organizers_description')
        </div>
    </div>

@endsection
