@extends('continents.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Country</h2>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $continent->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Code:</strong>
                {{ $continent->code }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('continents.index') }}"> Back</a>
        </div>
    </div>
@endsection
