@extends('countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Country</h2>
            </div>
        </div>
    </div>

   @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('countries.store') }}" method="POST">
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
                      'title' => 'Code',
                      'name' => 'code',
                      'placeholder' => 'Country code'
                ])
            </div>

            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => 'Continent',
                      'name' => 'continent_id',
                      'placeholder' => 'Select continent',
                      'records' => $continents
                ])
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('countries.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


    </form>


@endsection
