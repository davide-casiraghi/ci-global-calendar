@extends('eventVenues.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
            <div class="col-lg-12">
                <h4>@lang('views.edit_venue')</h4>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('eventVenues.update',$eventVenue->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('general.name'),
                        'name' => 'name',
                        'placeholder' => __('homepage-serach.venue_name'),
                        'value' => $eventVenue->name,
                        'required' => true,
                    ])
                </div>

                {{-- Show the created by field just to the admin and super admin --}}
                @if(empty($authorUserId))
                    <div class="col-12">
                        @include('partials.forms.select', [
                            'title' => __('views.created_by'),
                            'name' => 'created_by',
                            'placeholder' => __('views.select_owner'),
                            'records' => $users,
                            'seleted' => $eventVenue->created_by,
                            'liveSearch' => 'true',
                            'mobileNativeMenu' => false,
                            'required' => false,
                        ])
                    </div>
                @endif

                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.street'),
                        'name' => 'address',
                        'value' => $eventVenue->address,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.city'),
                        'name' => 'city',
                        'value' => $eventVenue->city,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.state_province'),
                        'name' => 'state_province',
                        'value' => $eventVenue->state_province,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => __('views.country'),
                          'name' => 'country_id',
                          'placeholder' => __('views.select_country'), 
                          'records' => $countries,
                          'seleted' => $eventVenue->country_id,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.zip_code'),
                        'name' => 'zip_code',
                        'placeholder' => '',
                        'value' => $eventVenue->zip_code,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.website'),
                        'name' => 'website',
                        'placeholder' => 'https://...',
                        'value' => $eventVenue->website,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea', [
                        'title' => __('general.description'),
                        'name' => 'description',
                        'placeholder' => '',
                        'value' => $eventVenue->description,
                        'required' => false,
                    ])
                </div>
            </div>

            {{-- used to not update the slug --}}
            @include('partials.forms.input-hidden', [
                  'name' => 'slug',
                  'value' => $eventVenue->slug,
            ])

            @include('partials.forms.buttons-back-submit', [
                'route' => 'eventVenues.index'  
            ])

        </form>
    </div>
@endsection
