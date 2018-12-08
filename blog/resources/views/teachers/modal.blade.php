
{{--
    This modal is used in the event.create and event.edit view to add a new teacher
--}}

@extends('layouts.modal')

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

    <form action="{{ route('teachers.storeFromModal') }}" method="POST" enctype="multipart/form-data">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Name',
                      'name' => 'name',
                      'placeholder' => 'Teacher name'
                ])
            </div>

            <div class="col-12">
                <div class="form-group">
                    <strong>Country:</strong>
                    <select name="country_id" class="selectpicker" data-live-search="true" title="Select country">
                        @foreach ($countries as $value => $country)
                            <option value="{{$value}}">{!! $country !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <strong>Bio:</strong>
                    <textarea class="form-control" style="height:150px" name="bio" placeholder="Bio"></textarea>
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Year of starting to practice',
                      'name' => 'year_starting_practice',
                      'placeholder' => 'AAAA',
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Year of starting to teach',
                      'name' => 'year_starting_teach',
                      'placeholder' => 'AAAA',
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Facebook profile',
                      'name' => 'facebook',
                      'placeholder' => 'https://...',
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Website',
                      'name' => 'website',
                      'placeholder' => 'https://...',
                      'value' => ''
                ])
            </div>
            
            @include('partials.forms.upload-image', [
                  'title' => 'Upload profile picture',
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
