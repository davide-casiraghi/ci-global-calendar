@extends('teachers.layout')

@section('content')

    <div class="row">
        <div class="col-12 mb-5">
            <h2>{{ $user->name }}</h2>
        </div>
        <div class="col-12 mt-4">
            <h3>Country</h3>
            {{ $countries[$user->country_id] }}
        </div>
        <div class="col-12 mt-4">
            <h3>Description</h3>
            {!! $user->description !!}
        </div>

    </div>

@endsection
