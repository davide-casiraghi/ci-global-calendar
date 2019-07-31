@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.add_new_background_image')</h2>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('backgroundImages.store') }}" method="POST">
        @csrf

         <div class="row">
             <div class="col-12">

                 @include('laravel-form-partials::input', [
                       'title' => __('views.title'),
                       'name' => 'title',
                       'placeholder' => __('views.background_image_title'),
                       'value' => old('title'),
                       'required' => true,
                 ])

             </div>
        </div>

        @include('partials.forms.image-event', [ 
              'title' => __('views.background_image'),
              'db_column_name' => 'image_src'
        ])

        <div class="row mt-2">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('homepage-serach.photo_credits'), 
                      'name' => 'credits',
                      'placeholder' => __('views.who_took_the_photo'), 
                      'value' => old('credits'),
                      'required' => false,
                ])
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.orientation') *</strong>
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

    </form>


@endsection
