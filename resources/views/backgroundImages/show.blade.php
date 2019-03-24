@extends('backgroundImages.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show background image</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('backgroundImages.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $backgroundImage->name }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Slug:</strong>
                <img src="{{ $backgroundImage->image_src }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <strong>Credits:</strong>
                {{ $backgroundImage->credits }}
            </div>
        </div>
    </div>
@endsection
