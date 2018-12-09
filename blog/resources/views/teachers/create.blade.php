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
                <div class="form-group">
                    <strong>Bio:</strong>
                    <textarea class="form-control" style="height:150px" name="bio" placeholder="Bio"></textarea>
                </div>
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

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('teachers.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
