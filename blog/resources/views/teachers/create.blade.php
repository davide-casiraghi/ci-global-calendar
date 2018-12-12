@extends('teachers.layout')


@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_teacher')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Teacher name'
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
                @include('partials.forms.select', [
                      'title' => __('general.country'),
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                      'title' =>  __('views.bio'),
                      'name' => 'bio',
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.year_of_starting_to_practice'),
                      'name' => 'year_starting_practice',
                      'placeholder' => 'AAAA',
                      'value' => '',
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.year_of_starting_to_teach'),
                      'name' => 'year_starting_teach',
                      'placeholder' => 'AAAA',
                      'value' => '',
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                      'title' =>  __('views.significant_teachers'),
                      'name' => 'significant_teachers',
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.facebook_profile'),
                      'name' => 'facebook',
                      'placeholder' => 'https://...',
                      'value' => '',
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.website'),
                      'name' => 'website',
                      'placeholder' => 'https://...',
                      'value' => '',
                ])
            </div>

            @include('partials.forms.upload-image', [
                  'title' => __('views.upload_profile_picture'), 
                  'name' => 'profile_picture',
                  'value' => ''
            ])
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'teachers.index'  
        ])

    </form>

@endsection
