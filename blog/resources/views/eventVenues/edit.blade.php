@extends('eventVenues.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_venue')</h2>
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
                    'title' => __('general.name'),
                    'name' => 'name',
                    'placeholder' => 'Venue name',
                    'value' => $eventVenue->name
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-12">
                    @include('partials.forms.select', [
                        'title' => __('views.created_by'),
                        'name' => 'created_by',
                        'placeholder' => 'Select owner',
                        'records' => $users,
                        'seleted' => $eventVenue->created_by
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.street'),
                    'name' => 'address',
                    'value' => $eventVenue->address
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.city'),
                    'name' => 'city',
                    'value' => $eventVenue->city
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.state_province'),
                    'name' => 'state_province',
                    'value' => $eventVenue->state_province
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => __('views.country'),
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                      'seleted' => $eventVenue->country_id
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.zip_code'),
                    'name' => 'zip_code',
                    'placeholder' => '',
                    'value' => $eventVenue->zip_code
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.website'),
                    'name' => 'website',
                    'placeholder' => 'https://...',
                    'value' => $eventVenue->website
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                    'title' => __('general.description'),
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
