@extends('laravel-events-calendar::continents.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('laravel-events-calendar::continent.edit_continent')</h2>
            </div>
        </div>
    </div>

    @include('laravel-form-partials::error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('continents.update',$continent->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::general.name'),
                      'name' => 'name',
                      'placeholder' => 'Continent Name',
                      'value' => $continent->name,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('laravel-events-calendar::general.code'), 
                      'name' => 'code',
                      'value' => $continent->code,
                      'required' => true,
                ])
            </div>
        </div>

        @include('laravel-form-partials::buttons-back-submit', [
            'route' => 'continents.index'  
        ])

    </form>

@endsection
