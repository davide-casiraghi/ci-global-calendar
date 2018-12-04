@extends('organizers.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Organizer</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('organizers.update',$organizer->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                    'title' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Name',
                    'value' => $organizer->name
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    @include('partials.forms.select', [
                          'title' => 'Created by',
                          'name' => 'created_by',
                          'placeholder' => 'Select owner',
                          'records' => $users,
                          'seleted' => $organizer->created_by
                    ])
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                    'title' => 'Email',
                    'name' => 'email',
                    'placeholder' => 'Name',
                    'value' => $organizer->email
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                    'title' => 'Facebook profile',
                    'name' => 'facebook',
                    'placeholder' => 'https://...',
                    'value' => $organizer->facebook
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                    'title' => 'Website',
                    'name' => 'website',
                    'placeholder' => 'https://...',
                    'value' => $organizer->website
                ])
            </div>

        </div>

        <div class="row h-100 mt-3">
            <div class="col-xs-9 col-sm-9 col-md-9 pull-left my-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>Image</strong></span>
                    </div>
                    <input id="thumbnail" class="form-control" type="text" name="image" value="{{ $organizer->image }}">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 pull-right my-auto">
                <img id="holder" style="width:100%;" src="{{ $organizer->image }}">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('organizers.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
