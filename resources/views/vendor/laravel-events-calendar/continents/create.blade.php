@extends('laravel-events-calendar::continents.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_continent')</h2>
            </div>
        </div>
    </div>

   @include('laravel-events-calendar::partials.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('continents.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Continent Name',
                      'value' => old('name'),
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-events-calendar::partials.input', [
                      'title' => __('views.continent_code'),
                      'name' => 'code',
                      'value' => old('code'),
                      'required' => true,
                ])
            </div>
        </div>

        @include('laravel-events-calendar::partials.buttons-back-submit', [
            'route' => 'continents.index'  
        ])

    </form>

@endsection
