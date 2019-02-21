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
    <div class="row pt-4">
        <div class="col-12">
            <h4>@lang('views.add_new_event')</h4>
        </div>
    </div>
    
    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])
    
    <hr class="mt-3 mb-4">
    
    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <div class="row">
            <div class="container-fluid">
                
                {{-- Basics --}}
                    <div class="row">
                        <div class="col-12 col-md form-sidebar">
                            <h5 class="text-xl">Notice</h5>
                            <span>@lang('views.first_country_event_notice')</span>
                        </div>
                        <div class="col-12 col-md main">
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
                                              'records' => $users,
                                              'liveSearch' => 'true',
                                              'mobileNativeMenu' => false,
                                        ])
                                    </div>
                                @endif
                                
                                <div class="col-12">
                                    @include('partials.forms.select', [
                                          'title' => __('views.category'),
                                          'name' => 'category_id',
                                          'placeholder' => __('views.select_category'),
                                          'records' => $eventCategories,
                                          'liveSearch' => 'true',
                                          'mobileNativeMenu' => false,
                                    ])
                                </div>
                                
                                {{--<div class="col-12">
                                    @include('partials.forms.event.select-event-status')
                                </div>--}}
                            </div>
                        </div>
                    </div>
                
                <hr class="mt-3 mb-4">
                
                {{-- Description --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">@lang('general.description')</h5>
                            <span>@lang('views.please_insert_english_translation')</span>
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.forms.textarea', [
                                          'title' =>  __('general.description'),
                                          'name' => 'description',
                                          'placeholder' => 'Event description',
                                          'value' => old('description')
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                
                <hr class="mt-3 mb-4">
                
                {{-- People --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">@lang('views.people')</h5>
                            <span>@lang('views.select_one_or_more')</span>
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.forms.event.select-event-teacher')
                                    @include('partials.forms.event.select-event-organizer')
                                </div>
                            </div>
                        </div>
                    </div>
                
                <hr class="mt-3 mb-4">
                
                {{-- Venue --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">Venue</h5>
                            
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.forms.event.select-event-venue')
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <hr class="mt-3 mb-4">
                    
                {{-- Duration --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">@lang('views.start_end_duration')</h5>
                            
                        </div>
                        <div class="col main">
                            {{-- Start date --}}
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
                            
                            {{-- End date --}}
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
                            
                            {{-- Repetitions --}}
                                @include('partials.forms.event.repeat-event')
                            
                            
                        </div>
                    </div>
                
                <hr class="mt-3 mb-4">
                
                
                {{-- Links --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">Links</h5>
                            
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.forms.input', [
                                          'title' =>  __('views.facebook_event'),
                                          'name' => 'facebook_event_link',
                                          'placeholder' => 'https://www.facebook.com/events/...',
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
                        </div>
                    </div>
                    
                <hr class="mt-3 mb-4">
                
                {{-- Event teaser image --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">Event teaser image</h5>
                            
                        </div>
                        <div class="col main">
                            <div class="row">
                                @include('partials.forms.upload-image', [
                                      'title' => __('views.upload_event_teaser_image'), 
                                      'name' => 'image',
                                      'folder' => 'events_teaser',
                                      'value' => ''
                                ])
                            </div>
                        </div>
                    </div>
                    
                <hr class="mt-3 mb-5">
                    
                
            </div>
        </div>

        <div class="row mt-2">  
            <div class="col-12 action">
                @include('partials.forms.buttons-back-submit', [
                    'route' => 'events.index'  
                ])
            </div>
        </div>

    </form>

@endsection
