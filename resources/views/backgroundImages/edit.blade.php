@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_background_image')</h2>
            </div>
        </div>
    </div>

    @include('laravel-form-partials::error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('backgroundImages.update',$backgroundImage->id) }}" method="POST">
        @csrf
        @method('PUT')


         <div class="row">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => 'Title',
                      'name' => 'title',
                      'placeholder' => 'Event title',
                      'value' => $backgroundImage->title,
                      'required' => true,
                ])
            </div>
        </div>

        @include('partials.forms.image-event', [
            'title' => __('views.background_image'),
            'db_column_name' => 'image_src',
            'image' => $backgroundImage->image_src
        ])

        <div class="row mt-2">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                      'title' => __('homepage-serach.photo_credits'), 
                      'name' => 'credits',
                      'placeholder' => 'Who took the photo?',
                      'value' => $backgroundImage->credits,
                      'required' => false,
                ])
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.orientation') *</strong>
                    <select name="orientation" class="selectpicker" title="Select orientation">
                            <option value="1" @if($backgroundImage->orientation == 1) {{ 'selected' }}@endif>@lang('views.horizontal')</option>
                            <option value="2" @if($backgroundImage->orientation == 2) {{ 'selected' }}@endif>@lang('views.vertical')</option>
                    </select>
                </div>
            </div>
        </div>
        
        @include('laravel-form-partials::buttons-back-submit', [
              'route' => 'backgroundImages.index'  
        ])

    </form>


@endsection
