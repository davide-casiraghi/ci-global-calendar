@extends('teachers.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Teacher</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Name',
                      'name' => 'name',
                      'placeholder' => 'Teacher name'
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @include('partials.forms.select', [
                          'title' => 'Created by',
                          'name' => 'created_by',
                          'placeholder' => 'Select owner',
                          'records' => $users
                    ])
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select', [
                      'title' => 'Country',
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Bio:</strong>
                    <textarea class="form-control" style="height:150px" name="bio" placeholder="Bio"></textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Year of starting to practice',
                      'name' => 'year_starting_practice',
                      'placeholder' => 'AAAA',
                      'value' => '',
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Year of starting to teach',
                      'name' => 'year_starting_teach',
                      'placeholder' => 'AAAA',
                      'value' => '',
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Facebook profile',
                      'name' => 'facebook',
                      'placeholder' => 'https://...',
                      'value' => '',
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Website',
                      'name' => 'website',
                      'placeholder' => 'https://...',
                      'value' => '',
                ])
            </div>

            @include('partials.forms.upload-image', [
                  'title' => 'Upload profile picture',
                  'name' => 'profile_picture',
                  'value' => ''
            ])
        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('teachers.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
