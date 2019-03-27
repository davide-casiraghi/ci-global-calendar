@extends('eventVenues.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('views.add_new_venue')</h4>
            </div>
        </div>

        @include('partials.forms.error-management', [
            'style' => 'alert-danger',
        ])

        <form action="{{ route('eventVenues.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('general.name'),
                        'name' => 'name',
                        'placeholder' => __('homepage-serach.venue_name'),
                        'value' => old('name'),
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
                        'placeholder' => '',
                        'value' => old('address'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.city'),
                        'name' => 'city',
                        'placeholder' => '',
                        'value' => old('city'),
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.state_province'),
                        'name' => 'state_province',
                        'placeholder' => '',
                        'value' => old('state_province'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => __('views.country'),
                          'name' => 'country_id',
                          'placeholder' => __('views.select_country'), 
                          'records' => $countries,
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
                        'value' => old('zip_code'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => __('views.website'),
                        'name' => 'website',
                        'placeholder' => 'https://...',
                        'value' => old('website'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea', [
                        'title' => __('general.description'),
                        'name' => 'description',
                        'placeholder' => '',
                        'value' => old('description'),
                        'required' => false,
                    ])
                </div>
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'eventVenues.index'  
            ])

        </form>
    </div>

@endsection
