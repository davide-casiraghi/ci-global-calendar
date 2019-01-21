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
                      'placeholder' => '',
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
                      'placeholder' => __('general.select_continent'),
                      'records' => $continents,
                      'seleted' => $country->continent_id,
                      'liveSearch' => 'false',
                      'mobileNativeMenu' => true,
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'countries.index'  
        ])
        
    </form>


@endsection
