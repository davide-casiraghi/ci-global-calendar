@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_background_image')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('backgroundImages.store') }}" method="POST">
        @csrf

         <div class="row">
             <div class="col-12">

                 @include('partials.forms.input', [
                       'title' => __('views.title'),
                       'name' => 'title',
                       'placeholder' => __('views.background_image_title'),
                 ])

             </div>
        </div>

        @include('partials.forms.image-event', [ 
              'title' => __('views.background_image'),
              'db_column_name' => 'image_src'
        ])

        <div class="row mt-2">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('homepage-serach.photo_credits'), 
                      'name' => 'credits',
                      'placeholder' => __('views.who_took_the_photo'), 
                ])
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.orientation'):</strong>
                    <select name="orientation" class="selectpicker" title="@lang('views.select_orientation')">
                            <option value="1">@lang('views.horizontal')</option>
                            <option value="2">@lang('views.vertical')</option>
                    </select>
                </div>
            </div>
        </div>
        
        @include('partials.forms.buttons-back-submit', [
              'route' => 'backgroundImages.index'  
        ])

{{--
        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('backgroundImages.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>
--}}


    </form>


@endsection
