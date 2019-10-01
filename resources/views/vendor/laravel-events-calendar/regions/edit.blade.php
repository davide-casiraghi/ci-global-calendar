@extends('laravel-events-calendar::countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('laravel-events-calendar::region.edit_region')</h2>
            </div>
        </div>
    </div>


    @include('laravel-form-partials::error-management', [
      'style' => 'alert-danger',
    ])


    <form action="{{ route('countries.update',$region->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::general.name'),
                      'name' => 'name',
                      'placeholder' => '',
                      'value' => $region->name,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::general.code'),
                      'name' => 'code',
                      'value' => $region->code,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::select', [
                      'title' => __('laravel-events-calendar::general.country'),
                      'name' => 'country_id',
                      'placeholder' => __('laravel-events-calendar::general.select_country'),
                      'records' => $countries,
                      'selected' => $region->country_id,
                      'liveSearch' => 'false',
                      'mobileNativeMenu' => true,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::region.timezone'),
                      'name' => 'timezone',
                      'placeholder' => 'Please specify as +2:00 or -5:00 or just Z if the time is in UTC',
                      'value' => $region->timezone,
                      'required' => true,
                ])
            </div>  
        </div>

        @include('laravel-form-partials::buttons-back-submit', [
            'route' => 'countries.index'  
        ])
        
    </form>


@endsection
