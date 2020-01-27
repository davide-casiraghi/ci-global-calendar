@extends('laravel-events-calendar::events.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <h2 class="mb-4">@lang('laravel-events-calendar::event.report_sent')</h2>
            @lang('laravel-events-calendar::event.thank_you_for_your_support')<br />
            @lang('laravel-events-calendar::event.administrator_will_check')
        </div>
    </div>

@endsection
