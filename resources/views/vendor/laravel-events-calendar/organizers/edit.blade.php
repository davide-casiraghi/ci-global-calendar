@extends('laravel-events-calendar::organizers.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('views.edit_organizer')</h4>
            </div>
        </div>

        @include('laravel-events-calendar::partials.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('organizers.update',$organizer->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('general.name'),
                        'name' => 'name',
                        'placeholder' => __('homepage-serach.organizer_name'),
                        'value' => $organizer->name,
                        'required' => true,
                    ])
                </div>

                {{-- Show the created by field just to the admin and super admin --}}
                @if(empty($authorUserId))
                    <div class="col-12">
                        @include('laravel-events-calendar::partials.select', [
                              'title' => __('views.created_by'),
                              'name' => 'created_by',
                              'placeholder' => __('views.select_owner'),
                              'records' => $users,
                              'seleted' => $organizer->created_by,
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                              'required' => false,
                        ])
                    </div>
                @endif

                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('general.email_address'),
                        'name' => 'email',
                        'value' => $organizer->email,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('general.phone'),
                        'name' => 'phone',
                        'value' => $organizer->phone,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-events-calendar::partials.input', [
                        'title' => __('views.website'),
                        'name' => 'website',
                        'placeholder' => 'https://...',
                        'value' => $organizer->website,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-events-calendar::partials.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => '',
                          'value' => $organizer->description,
                          'required' => false,
                    ])
                </div>
            </div>

            {{-- used to not update the slug --}}
            @include('laravel-events-calendar::partials.input-hidden', [
                  'name' => 'slug',
                  'value' => $organizer->slug,
            ])

            @include('laravel-events-calendar::partials.buttons-back-submit', [
                'route' => 'organizers.index'  
            ])

        </form>
    </div>
@endsection
