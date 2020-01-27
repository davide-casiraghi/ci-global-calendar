@extends('laravel-events-calendar::events.layout')

@section('content')
    <div class="container max-w-lg px-0">
        <div class="row py-4">
            <div class="col-8">
                <h4>@lang('laravel-events-calendar::event.edit_event')</h4>
            </div>
            <div class="col-4 text-right">
                <form action="{{ route('events.destroy',$event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pr-0">@lang('laravel-events-calendar::event.delete_event')</button>
                </form>
            </div>
        </div>
        
        @include('laravel-form-partials::error-management', [
              'style' => 'alert-danger',
        ])
        
        <hr class="mt-3 mb-4">

        <form action="{{ route('events.update',$event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Basics --}}
                <div class="row">
                    <div class="col-12 col-md form-sidebar">
                        <h5 class="text-xl">@lang('laravel-events-calendar::event.notice')</h5>
                        <span class="dark-gray">@lang('laravel-events-calendar::event.first_country_event_notice')</span>
                    </div>
                    <div class="col-12 col-md main">
                        <div class="row">
                           <div class="col-12">
                               @include('laravel-form-partials::input', [
                                     'title' => __('laravel-events-calendar::general.title'),
                                     'name' => 'title',
                                     'placeholder' => 'Event title',
                                     'value' => $event->title,
                                     'required' => true,
                               ])
                           </div>

                           {{-- Show the created by field just to the admin and super admin --}}
                           <div class="col-12 @if(!empty($authorUserId)) d-none @endif">
                               @include('laravel-form-partials::select', [
                                     'title' =>  __('laravel-events-calendar::general.created_by'), 
                                     'name' => 'created_by',
                                     'placeholder' => 'Select owner',
                                     'records' => $users,
                                     'selected' => $event->created_by,
                                     'liveSearch' => 'true',
                                     'mobileNativeMenu' => false,
                                     'required' => false,
                               ])
                           </div>
                           

                           <div class="col-12">
                               @include('laravel-form-partials::select', [
                                     'title' => __('laravel-events-calendar::event.category'),
                                     'name' => 'category_id',
                                     'placeholder' => 'Select category',
                                     'records' => $eventCategories,
                                     'selected' => $event->category_id,
                                     'liveSearch' => 'true',
                                     'mobileNativeMenu' => false,
                                     'required' => true,
                               ])
                           </div>

                           <div class="col-12">
                               @include('laravel-events-calendar::partials.event.select-event-status')
                           </div>
                       </div>
                    </div>
                </div>
            
            <hr class="mt-3 mb-4">
            
            {{-- People --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('laravel-events-calendar::event.people')</h5>
                        <span class="dark-gray">@lang('laravel-events-calendar::event.select_one_or_more_people')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('laravel-events-calendar::partials.event.select-event-teacher')
                                @include('laravel-events-calendar::partials.event.select-event-organizer')
                            </div>
                        </div>
                    </div>
                </div>

            <hr class="mt-3 mb-4">

            {{-- Venue --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">Venue</h5>
                        <span class="dark-gray">@lang('laravel-events-calendar::event.select_venue')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('laravel-events-calendar::partials.event.select-event-venue', [
                                      'selected' => $event->venue_id,
                                ]) 
                            </div>
                        </div>
                    </div>
                </div>

            <hr class="mt-3 mb-4">
                        
            {{-- Description --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('laravel-events-calendar::general.description')</h5>
                        <span class="dark-gray">@lang('laravel-events-calendar::event.please_insert_english_translation')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('laravel-form-partials::textarea', [
                                      'title' =>  __('laravel-events-calendar::general.description'),
                                      'name' => 'description',
                                      'placeholder' => 'Event description',
                                      'value' => $event->description,
                                      'required' => true,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            <hr class="mt-3 mb-4">
                    
            {{-- Duration --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('laravel-events-calendar::event.start_end_duration')</h5>
                        <span class="dark-gray">@lang('laravel-events-calendar::event.please_use_repeat_until')</span>
                    </div>
                    <div class="col main">
                        {{-- Start date --}}
                        <div class="row">
                            <div class="col-6">
                                @include('laravel-form-partials::input-date', [
                                      'title' => __('laravel-events-calendar::event.date_start'),
                                      'name' => 'startDate',
                                      'placeholder' => __('laravel-events-calendar::general.select_date'),
                                      'value' => $dateTime['dateStart'],
                                      'required' => true,
                                ])
                            </div>

                            <div class="col-6">
                                @include('laravel-form-partials::input-time', [
                                      'title' =>  __('laravel-events-calendar::event.time_start'),
                                      'name' => 'time_start',
                                      'placeholder' => __('laravel-events-calendar::event.select_time'),
                                      'value' => $dateTime['timeStart'],
                                      'required' => true,
                                ])
                            </div>
                        </div>
                        
                        {{-- End date --}}
                        <div class="row">
                            <div class="col-6">
                                @include('laravel-form-partials::input-date', [
                                      'title' =>  __('laravel-events-calendar::event.date_end'),
                                      'name' => 'endDate',
                                      'placeholder' => __('laravel-events-calendar::general.select_date'),
                                      'value' => $dateTime['dateEnd'],
                                      'required' => true,
                                ])
                            </div>
                            <div class="col-6">
                                @include('laravel-form-partials::input-time', [
                                      'title' =>  __('laravel-events-calendar::event.time_end'),
                                      'name' => 'time_end',
                                      'placeholder' => __('laravel-events-calendar::event.select_time'),
                                      'value' => $dateTime['timeEnd'],
                                      'required' => true,
                                ])
                            </div>
                        </div>
                        
                        {{-- Repetitions --}}
                            @include('laravel-events-calendar::partials.event.repeat-event', [
                                  'event' => $event
                            ])
                        
                    </div>
                </div>
            
            <hr class="mt-3 mb-4">
                
            {{-- Links --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('laravel-events-calendar::event.contacts_and_links')</h5>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('laravel-form-partials::input', [
                                      'title' =>  __('laravel-events-calendar::event.email_for_more_info'),
                                      'name' => 'contact_email',
                                      'placeholder' => '', //__('laravel-events-calendar::event.email_for_more_info_placeholder')
                                      'value' => $event->contact_email,
                                      'required' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('laravel-form-partials::input', [
                                      'title' =>  __('laravel-events-calendar::event.facebook_event'),
                                      'name' => 'facebook_event_link',
                                      'placeholder' => 'https://www.facebook.com/events/...',
                                      'value' => $event->facebook_event_link,
                                      'required' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('laravel-form-partials::input', [
                                      'title' => __('laravel-events-calendar::event.event_url'),
                                      'name' => 'website_event_link',
                                      'placeholder' => 'https://www...',
                                      'value' => $event->website_event_link,
                                      'required' => false,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                
            <hr class="mt-3 mb-4">
                
            {{-- Event teaser image --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('laravel-events-calendar::event.event_teaser_image')</h5>
                        
                    </div>
                    <div class="col main">
                        <div class="row">
                            @include('laravel-form-partials::upload-image', [
                                  'title' => __('laravel-events-calendar::event.upload_event_teaser_image'), 
                                  'name' => 'image',
                                  'folder' => 'events_teaser',
                                  'value' => $event->image,
                            ])
                        </div>
                    </div>
                </div>
                    
            <hr class="mt-3 mb-5">
                    
            {{-- used to not update the slug --}}
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'slug',
                  'value' => $event->slug,
            ])
            
            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('laravel-form-partials::buttons-back-submit', [
                        'route' => 'events.index'  
                    ])
                </div>
            </div>

        </form>
    </div>
@endsection
