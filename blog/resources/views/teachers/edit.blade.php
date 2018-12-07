@extends('teachers.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Teacher</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('teachers.update',$teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Name',
                    'value' => $teacher->name
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => 'Created by',
                          'name' => 'created_by',
                          'placeholder' => 'Select owner',
                          'records' => $users,
                          'seleted' => $teacher->created_by
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => 'Country',
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                      'seleted' => $teacher->country_id
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => 'Bio',
                      'name' => 'bio',
                      'placeholder' => 'Teacher Bio',
                      'value' => $teacher->bio
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Year of starting to practice',
                      'name' => 'year_starting_practice',
                      'placeholder' => 'AAAA',
                      'value' => $teacher->year_starting_practice,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Year of starting to teach',
                      'name' => 'year_starting_teach',
                      'placeholder' => 'AAAA',
                      'value' => $teacher->year_starting_teach,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Facebook profile',
                      'name' => 'facebook',
                      'placeholder' => 'https://...',
                      'value' => $teacher->facebook ,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Website',
                      'name' => 'website',
                      'placeholder' => 'https://...',
                      'value' => $teacher->website ,
                ])
            </div>

            @include('partials.forms.upload-image', [
                  'title' => 'Upload profile picture',
                  'name' => 'profile_picture',
                  'value' => $teacher->profile_picture ,
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
