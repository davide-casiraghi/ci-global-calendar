@extends('laravel-events-calendar::countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('laravel-events-calendar::country.add_new_country')</h2>
            </div>
        </div>
    </div>

   @include('laravel-form-partials::error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('countries.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::general.name'),
                      'name' => 'name',
                      'placeholder' => '',
                      'value' => old('name'),
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::general.code'),
                      'name' => 'code',
                      'value' => old('code'),
                      'required' => true,
                ])
            </div>

            <div class="col-12">
                @include('laravel-form-partials::select', [
                      'title' => __('laravel-events-calendar::general.continent'),
                      'name' => 'continent_id',
                      'placeholder' => __('laravel-events-calendar::general.select_continent'),
                      'records' => $continents,
                      'liveSearch' => 'false',
                      'mobileNativeMenu' => true,
                      'selected' => old('continent_id'),
                      'required' => true,
                ])
            </div>
        </div>

        @include('laravel-form-partials::buttons-back-submit', [
            'route' => 'countries.index'  
        ])

    </form>


@endsection
