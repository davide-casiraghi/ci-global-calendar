@extends('laravel-events-calendar::countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Country</h2>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $country->name }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Code:</strong>
                {{ $country->code }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Continent:</strong>
                {{ $country->continent_id }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('countries.index') }}"> Back</a>
        </div>
    </div>
@endsection
