@extends('eventCategories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Event Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('eventCategories.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])


    <form action="{{ route('eventCategories.store') }}" method="POST">
        @csrf


         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>


@endsection
