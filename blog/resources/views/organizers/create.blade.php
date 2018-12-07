@extends('organizers.layout')


@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Organizer</h2>
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
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Name'
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => 'Created by',
                          'name' => 'created_by',
                          'placeholder' => 'Select owner',
                          'records' => $users
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Email',
                    'name' => 'email',
                    'placeholder' => 'Name'
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Phone',
                    'name' => 'phone',
                    'placeholder' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Website',
                    'name' => 'website',
                    'placeholder' => 'https://...'
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => 'Description (optional)',
                      'name' => 'description',
                      'placeholder' => 'Organizer description'
                ])
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('organizers.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
