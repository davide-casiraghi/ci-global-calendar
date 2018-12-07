@extends('eventVenues.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit event Venue</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('eventVenues.update',$eventVenue->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Name',
                    'value' => $eventVenue->name
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
                        'seleted' => $eventVenue->created_by
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Street',
                    'name' => 'address',
                    'placeholder' => '',
                    'value' => $eventVenue->address
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'City',
                    'name' => 'city',
                    'placeholder' => '',
                    'value' => $eventVenue->city
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'State/Province',
                    'name' => 'state_province',
                    'placeholder' => '',
                    'value' => $eventVenue->state_province
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => 'Country',
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                      'seleted' => $eventVenue->country_id
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Zip code',
                    'name' => 'zip_code',
                    'placeholder' => '',
                    'value' => $eventVenue->zip_code
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Website',
                    'name' => 'website',
                    'placeholder' => 'https://...',
                    'value' => $eventVenue->website
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                    'title' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Event description',
                    'value' => $eventVenue->description
                ])
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('eventVenues.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
