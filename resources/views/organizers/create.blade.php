@extends('organizers.layout')


@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_organizer')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('organizers.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('general.name'),
                    'name' => 'name',
                    'placeholder' => __('homepage-serach.organizer_name'), 
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => __('views.created_by'),
                          'name' => 'created_by',
                          'placeholder' => __('views.select_owner'),
                          'records' => $users
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('general.email_address'),
                    'name' => 'email',
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('general.phone'),
                    'name' => 'phone',
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.website'),
                    'name' => 'website',
                    'placeholder' => 'https://...'
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => __('general.description'),
                      'name' => 'description',
                      'placeholder' => ''
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'organizers.index'  
        ])

    </form>

@endsection
