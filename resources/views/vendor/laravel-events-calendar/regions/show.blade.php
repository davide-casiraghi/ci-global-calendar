@extends('laravel-events-calendar::regions.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Region / State</h2>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $region->name }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Code:</strong>
                {{ $region->code }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Country:</strong>
                {{ $region->country_id }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Timezone:</strong>
                {{ $region->timezone }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('regions.index') }}"> Back</a>
        </div>
    </div>
@endsection
