
{{--
    This modal is used in the event.create and event.edit view to add a new teacher
--}}

@extends('layouts.modal')

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

    <form action="{{ route('teachers.storeFromModal') }}" method="POST" enctype="multipart/form-data">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Teacher name'
                ])
            </div>

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
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.year_of_starting_to_teach'),
                      'name' => 'year_starting_teach',
                      'placeholder' => 'AAAA',
                      'value' => ''
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
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.website'),
                      'name' => 'website',
                      'placeholder' => 'https://...',
                      'value' => ''
                ])
            </div>
            
            @include('partials.forms.upload-image', [
                  'title' => __('views.upload_profile_picture'), 
                  'name' => 'profile_picture',
                  'value' => ''
            ])
        </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
