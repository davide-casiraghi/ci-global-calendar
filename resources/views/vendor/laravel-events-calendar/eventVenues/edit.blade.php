@extends('laravel-events-calendar::eventVenues.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
            <div class="col-lg-12">
                <h4>@lang('laravel-events-calendar::eventVenue.edit_venue')</h4>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('eventVenues.update',$eventVenue->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::general.name'),
                        'name' => 'name',
                        'placeholder' => __('laravel-events-calendar::eventVenue.venue_name'),
                        'value' => $eventVenue->name,
                        'required' => true,
                    ])
                </div>

                {{-- Show the created by field just to the admin and super admin --}}
                @if(empty($authorUserId))
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                            'title' => __('laravel-events-calendar::general.created_by'),
                            'name' => 'created_by',
                            'placeholder' => __('laravel-events-calendar.select_owner'),
                            'records' => $users,
                            'selected
' => $eventVenue->created_by,
                            'liveSearch' => 'true',
                            'mobileNativeMenu' => false,
                            'required' => false,
                        ])
                    </div>
                @endif

                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.street'),
                        'name' => 'address',
                        'value' => $eventVenue->address,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.city'),
                        'name' => 'city',
                        'value' => $eventVenue->city,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.state_province'),
                        'name' => 'state_province',
                        'value' => $eventVenue->state_province,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::select', [
                          'title' => __('laravel-events-calendar::general.country'),
                          'name' => 'country_id',
                          'placeholder' => __('laravel-events-calendar::general.select_country'), 
                          'records' => $countries,
                          'selected
' => $eventVenue->country_id,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.zip_code'),
                        'name' => 'zip_code',
                        'placeholder' => '',
                        'value' => $eventVenue->zip_code,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::general.website'),
                        'name' => 'website',
                        'placeholder' => 'https://...',
                        'value' => $eventVenue->website,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::textarea', [
                        'title' => __('laravel-events-calendar::general.description'),
                        'name' => 'description',
                        'placeholder' => '',
                        'value' => $eventVenue->description,
                        'required' => false,
                    ])
                </div>
            </div>

            {{-- used to not update the slug --}}
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'slug',
                  'value' => $eventVenue->slug,
            ])

            @include('laravel-form-partials::buttons-back-submit', [
                'route' => 'eventVenues.index'  
            ])

        </form>
    </div>
@endsection
