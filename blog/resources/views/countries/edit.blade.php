@extends('countries.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Country</h2>
            </div>
        </div>
    </div>


    @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])


    <form action="{{ route('countries.update',$country->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $country->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Code:</strong>
                    <input type="text" name="code" value="{{ $country->code }}" class="form-control" placeholder="Slug">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Continent:</strong>
                    <select name="continent_id" class="selectpicker" title="Select continent">
                        @foreach ($continents as $value => $continent)
                            <option value="{{$value}}" {{ $country->continent_id == $value ? 'selected' : '' }}>{!! $continent !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('countries.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


    </form>


@endsection
