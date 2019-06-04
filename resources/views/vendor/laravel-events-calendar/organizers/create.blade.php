@extends('laravel-events-calendar::organizers.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('laravel-events-calendar::organizer.add_new_organizer')</h4>
            </div>
        </div>

        @include('laravel-events-calendar::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('organizers.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('laravel-events-calendar::general.name'),
                        'name' => 'name',
                        'placeholder' => '', 
                        'value' => old('name'),
                        'required' => true,
                    ])
                </div>

                {{-- Show the created by field just to the admin and super admin --}}
                @if(empty($authorUserId))
                    <div class="col-12">
                        @include('laravel-events-calendar::partials.select', [
                              'title' => __('laravel-events-calendar::general.created_by'),
                              'name' => 'created_by',
                              'placeholder' => __('laravel-events-calendar.select_owner'),
                              'records' => $users,
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                              'seleted' => old('created_by'),
                              'required' => false,
                        ])
                    </div>
                @endif

                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('laravel-events-calendar::general.email_address'),
                        'name' => 'email',
                        'value' => old('email'),
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('laravel-events-calendar::general.phone'),
                        'name' => 'phone',
                        'value' => old('phone'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('laravel-events-calendar::general.website'),
                        'name' => 'website',
                        'placeholder' => 'https://...',
                        'value' => old('website'),
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-events-calendar::partials.textarea', [
                          'title' => __('laravel-events-calendar::general.description'),
                          'name' => 'description',
                          'placeholder' => '',
                          'value' => old('description'),
                          'required' => false,
                    ])
                </div>
            </div>

            @include('laravel-events-calendar::partials.buttons-back-submit', [
                'route' => 'organizers.index'  
            ])

        </form>
    </div>
@endsection
