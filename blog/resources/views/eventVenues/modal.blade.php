@extends('layouts.modal')

@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Venue</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('eventVenues.storeFromModal') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Name'
                ])
            </div>
            
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Street',
                    'name' => 'address',
                    'placeholder' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'City',
                    'name' => 'city',
                    'placeholder' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'State/Province',
                    'name' => 'state_province',
                    'placeholder' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => 'Country',
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Zip code',
                    'name' => 'zip_code',
                    'placeholder' => '',
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
            <div class="col-12">
                @include('partials.forms.textarea', [
                    'title' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Event description'
                ])
            </div>
       </div>

       <div class="row mt-5">
           <div class="col-6 pull-left">
               <a class="btn btn-primary" href="{{ route('eventVenues.index') }}">Back</a>
           </div>
           <div class="col-6 pull-right">
             <button type="submit" class="btn btn-primary float-right">Submit</button>
           </div>
       </div>

    </form>

@endsection
