@extends('laravel-events-calendar::eventVenues.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('laravel-events-calendar::eventVenue.add_new_venue')</h4>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
            'style' => 'alert-danger',
        ])

        <form action="{{ route('eventVenues.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::general.name'),
                        'name' => 'name',
                        'placeholder' => '',
                        'value' => old('name'),
                        'required' => true,
                    ])
                </div>

                {{-- Show the created by field just to the admin and super admin --}}
                <div class="col-12 @if(!empty($authorUserId)) d-none @endif">
                    @include('laravel-form-partials::select', [
                        'title' => __('laravel-events-calendar::general.created_by'),
                        'name' => 'created_by',
                        'placeholder' => __('laravel-events-calendar::general.select_owner'),
                        'records' => $users,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                        'selected' => Auth::id(),
                        'required' => false,
                    ])
                </div>
                

                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.street'),
                        'name' => 'address',
                        'placeholder' => '',
                        'value' => old('address'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.city'),
                        'name' => 'city',
                        'placeholder' => '',
                        'value' => old('city'),
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::eventVenue.state_province'),
                        'name' => 'state_province',
                        'placeholder' => '',
                        'value' => old('state_province'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::select', [
                          'title' => __('laravel-events-calendar::eventVenue.country'),
                          'name' => 'country_id',
                          'placeholder' => __('laravel-events-calendar::general.select_country'), 
                          'records' => $countries,
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
                        'value' => old('zip_code'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::general.website'),
                        'name' => 'website',
                        'placeholder' => 'https://...',
                        'value' => old('website'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::textarea', [
                        'title' => __('laravel-events-calendar::general.description'),
                        'name' => 'description',
                        'placeholder' => '',
                        'value' => old('description'),
                        'required' => false,
                    ])
                </div>
            </div>

            @include('laravel-form-partials::buttons-back-submit', [
                'route' => 'eventVenues.index'  
            ])

        </form>
    </div>

@endsection
