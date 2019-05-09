@extends('laravel-events-calendar::countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_country')</h2>
            </div>
        </div>
    </div>


    @include('laravel-events-calendar::partials.error-management', [
      'style' => 'alert-danger',
    ])


    <form action="{{ route('countries.update',$country->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => '',
                      'value' => $country->name,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('views.country_code'),
                      'name' => 'code',
                      'value' => $country->code,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.select', [
                      'title' => __('general.continent'),
                      'name' => 'continent_id',
                      'placeholder' => __('general.select_continent'),
                      'records' => $continents,
                      'seleted' => $country->continent_id,
                      'liveSearch' => 'false',
                      'mobileNativeMenu' => true,
                      'required' => true,
                ])
            </div>
        </div>

        @include('laravel-events-calendar::partials.buttons-back-submit', [
            'route' => 'countries.index'  
        ])
        
    </form>


@endsection
