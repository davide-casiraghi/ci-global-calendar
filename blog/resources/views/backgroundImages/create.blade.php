@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Background image</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management')

    <form action="{{ route('backgroundImages.store') }}" method="POST">
        @csrf

         <div class="row">
             <div class="col-xs-12 col-sm-12 col-md-12">

                 @include('partials.forms.input', [
                       'title' => 'Title',
                       'name' => 'title',
                       'placeholder' => 'Image title - just to recognize it'
                 ])

             </div>
        </div>

        @include('partials.forms.image-event', [
              'title' => 'Background image',
              'db_column_name' => 'image_src',
              'folder' => 'backgroundImages'
        ])

        <div class="row mt-2">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Credits',
                      'name' => 'credits',
                      'placeholder' => 'Who took the photo?'
                ])
            </div>

        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('backgroundImages.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


    </form>


@endsection
