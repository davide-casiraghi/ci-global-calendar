@extends('events.layout')

@section('content')
    <div class="container max-w-lg px-0">
        <div class="row py-4">
            <div class="col-8">
                <h4>@lang('views.edit_event')</h4>
            </div>
            <div class="col-4 text-right">
                <form action="{{ route('events.destroy',$event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pr-0">@lang('views.delete_event')</button>
                </form>
            </div>
        </div>
        
        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])
        
        <hr class="mt-3 mb-4">

        <form action="{{ route('events.update',$event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Basics --}}
                <div class="row">
                    <div class="col-12 col-md form-sidebar">
                        <h5 class="text-xl">Notice</h5>
                        <span class="dark-gray">@lang('views.first_country_event_notice')</span>
                    </div>
                    <div class="col-12 col-md main">
                        <div class="row">
                           <div class="col-12">
                               @include('partials.forms.input', [
                                     'title' => 'Title',
                                     'name' => 'title',
                                     'placeholder' => 'Event title',
                                     'value' => $event->title,
                                     'required' => true,
                               ])
                           </div>

                           {{-- Show the created by field just to the admin and super admin --}}
                           @if(empty($authorUserId))
                               <div class="col-12">
                                   @include('partials.forms.select', [
                                         'title' => 'Created by',
                                         'name' => 'created_by',
                                         'placeholder' => 'Select owner',
                                         'records' => $users,
                                         'seleted' => $event->created_by,
                                         'liveSearch' => 'true',
                                         'mobileNativeMenu' => false,
                                         'required' => false,
                                   ])
                               </div>
                           @endif

                           <div class="col-12">
                               @include('partials.forms.select', [
                                     'title' => 'Category',
                                     'name' => 'category_id',
                                     'placeholder' => 'Select category',
                                     'records' => $eventCategories,
                                     'seleted' => $event->category_id,
                                     'liveSearch' => 'true',
                                     'mobileNativeMenu' => false,
                                     'required' => true,
                               ])
                           </div>

                           <div class="col-12">
                               @include('partials.forms.event.select-event-status')
                           </div>
                       </div>
                    </div>
                </div>
            
            <hr class="mt-3 mb-4">
            
            {{-- People --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('views.people')</h5>
                        <span class="dark-gray">@lang('views.select_one_or_more_people')</span>
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
                        <span class="dark-gray">@lang('views.select_venue')</span>
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
                        
            {{-- Description --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('general.description')</h5>
                        <span class="dark-gray">@lang('views.please_insert_english_translation')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' => 'Description',
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
                        <h5 class="text-xl">@lang('views.start_end_duration')</h5>
                        <span class="dark-gray">@lang('views.please_use_repeat_until')</span>
                    </div>
                    <div class="col main">
                        {{-- Start date --}}
                        <div class="row">
                            <div class="col-6">
                                @include('partials.forms.input-date', [
                                      'title' => __('views.date_start'),
                                      'name' => 'startDate',
                                      'placeholder' => __('views.select_date'),
                                      'value' => $dateTime['dateStart'],
                                      'required' => true,
                                ])
                            </div>

                            <div class="col-6">
                                @include('partials.forms.input-time', [
                                      'title' =>  __('views.time_start'),
                                      'name' => 'time_start',
                                      'placeholder' => __('views.select_time'),
                                      'value' => $dateTime['timeStart'],
                                      'required' => true,
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
                                      'value' => $dateTime['dateEnd'],
                                      'required' => true,
                                ])
                            </div>
                            <div class="col-6">
                                @include('partials.forms.input-time', [
                                      'title' =>  __('views.time_end'),
                                      'name' => 'time_end',
                                      'placeholder' => __('views.select_time'),
                                      'value' => $dateTime['timeEnd'],
                                      'required' => true,
                                ])
                            </div>
                        </div>
                        
                        {{-- Repetitions --}}
                            @include('partials.forms.event.repeat-event', [
                                  'event' => $event
                            ])
                        
                    </div>
                </div>
            
            <hr class="mt-3 mb-4">
                
            {{-- Links --}}
                <div class="row">
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('views.contacts_and_links')</h5>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' =>  __('views.email_for_more_info'),
                                      'name' => 'contact_email',
                                      'placeholder' => '', //__('views.email_for_more_info_placeholder')
                                      'value' => $event->contact_email,
                                      'required' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' =>  __('views.facebook_event'),
                                      'name' => 'facebook_event_link',
                                      'placeholder' => 'https://www.facebook.com/events/...',
                                      'value' => $event->facebook_event_link,
                                      'required' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('views.event_url'),
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
                        <h5 class="text-xl">Event teaser image</h5>
                        
                    </div>
                    <div class="col main">
                        <div class="row">
                            @include('partials.forms.upload-image', [
                                  'title' => __('views.upload_event_teaser_image'), 
                                  'name' => 'image',
                                  'folder' => 'events_teaser',
                                  'value' => $event->image,
                            ])
                        </div>
                    </div>
                </div>
                    
            <hr class="mt-3 mb-5">
                    
            {{-- used to not update the slug --}}
            @include('partials.forms.input-hidden', [
                  'name' => 'slug',
                  'value' => $event->slug,
            ])
            
            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('partials.forms.buttons-back-submit', [
                        'route' => 'events.index'  
                    ])
                </div>
            </div>

        </form>
    </div>
@endsection
