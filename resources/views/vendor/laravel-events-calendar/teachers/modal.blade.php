
{{--
    This modal is used in the event.create and event.edit view to add a new teacher
    It is loaded in view/partials/forms/modal-frame when the 
    button "Add new teacher" is clicked in the event create view
--}}

@extends('laravel-events-calendar::layouts.modal')

@section('content')
    
    <div class="row">
        <div class="col-12">
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="col-12 pb-3">
            <h4>@lang('views.add_new_teacher')</h4>
        </div>
    </div>

    @include('laravel-events-calendar::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('teachers.storeFromModal') }}" method="POST" enctype="multipart/form-data">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Teacher name',
                      'required' => true,
                ])
            </div>

            <div class="col-12">
                @include('laravel-events-calendar::partials.select', [
                      'title' => __('general.country'),
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                      'liveSearch' => 'true',
                      'mobileNativeMenu' => false,
                      'required' => false,
                ])
            </div>

            <div class="col-12">
                @include('laravel-events-calendar::partials.textarea-plain', [
                      'title' =>  __('views.bio'),
                      'name' => 'bio',
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('views.year_of_starting_to_practice'),
                      'name' => 'year_starting_practice',
                      'placeholder' => 'AAAA',
                      'value' => '',
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('views.year_of_starting_to_teach'),
                      'name' => 'year_starting_teach',
                      'placeholder' => 'AAAA',
                      'value' => '',
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.textarea-plain', [
                      'title' =>  __('views.significant_teachers'),
                      'name' => 'significant_teachers',
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('views.facebook_profile'),
                      'name' => 'facebook',
                      'placeholder' => 'https://...',
                      'value' => '',
                      'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('views.website'),
                      'name' => 'website',
                      'placeholder' => 'https://...',
                      'value' => '',
                      'required' => false,
                ])
            </div>
            
            @include('laravel-events-calendar::partials.upload-image', [
                  'title' => __('views.upload_profile_picture'), 
                  'name' => 'profile_picture',
                  'value' => ''
            ])
        </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('general.close')</button>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">@lang('general.submit')</button>
            </div>
        </div>

    </form>

@endsection
