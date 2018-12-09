@extends('countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_country')</h2>
            </div>
        </div>
    </div>


    @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])


    <form action="{{ route('countries.update',$country->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Name',
                      'value' => $country->name
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('views.country_code'),
                      'name' => 'code',
                      'value' => $country->code
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                      'title' => __('general.continent'),
                      'name' => 'continent_id',
                      'placeholder' => 'Select continent',
                      'records' => $continents,
                      'seleted' => $country->continent_id
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
