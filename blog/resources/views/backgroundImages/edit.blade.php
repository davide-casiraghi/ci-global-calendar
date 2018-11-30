@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Background image</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('backgroundImages.update',$backgroundImage->id) }}" method="POST">
        @csrf
        @method('PUT')


         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Title',
                      'name' => 'title',
                      'placeholder' => 'Event title',
                      'value' => $backgroundImage->title
                ])
            </div>
        </div>

        @include('partials.forms.image-event', [
            'title' => 'Background image',
            'db_column_name' => 'image_src',
            'image' => $backgroundImage->image_src
        ])

        <div class="row mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Credits',
                      'name' => 'credits',
                      'placeholder' => 'Who took the photo?',
                      'value' => $backgroundImage->credits
                ])
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Orientation:</strong>
                    <select name="orientation" class="selectpicker" title="Select orientation">
                            <option value="0" @if(!$backgroundImage->orientation) {{  $backgroundImage->orientation == 0 ? 'selected' : '' }}@endif>Horizontal</option>
                            <option value="1" @if($backgroundImage->orientation) {{  $backgroundImage->orientation == 1 ? 'selected' : '' }}@endif>Vertical</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('backgroundImages.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


    </form>


@endsection
