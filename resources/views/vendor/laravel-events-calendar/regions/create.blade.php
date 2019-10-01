@extends('laravel-events-calendar::regions.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('laravel-events-calendar::region.add_new_region')</h2>
            </div>
        </div>
    </div>

   @include('laravel-form-partials::error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('regions.store') }}" method="POST">
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
                      'title' => __('laravel-events-calendar::general.country'),
                      'name' => 'country_id',
                      'placeholder' => __('laravel-events-calendar::general.select_country'),
                      'records' => $countries,
                      'liveSearch' => 'false',
                      'mobileNativeMenu' => true,
                      'selected' => old('country_id'),
                      'required' => true,
                ])
            </div>
            
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::region.timezone'),
                      'name' => 'timezone',
                      'placeholder' => 'Please specify as +2:00 or -5:00 or just Z if the time is in UTC',
                      'value' => old('timezone'),
                      'required' => true,
                ])
            </div>
        </div>
        

        @include('laravel-form-partials::buttons-back-submit', [
            'route' => 'regions.index'  
        ])

    </form>


@endsection
