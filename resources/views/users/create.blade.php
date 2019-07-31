@extends('users.layout')


@section('content')
    <div class="container max-w-sm px-0">
        
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('views.add_new_user')</h4>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => '',
                          'value' => old('name'),
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('general.email_address'),
                          'name' => 'email',
                          'value' => old('email'),
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('laravel-form-partials::password', [
                          'title' => __('general.password'),
                          'name' => 'password',
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('laravel-form-partials::password', [
                          'title' => __('general.confirm_password'),
                          'name' => 'password_confirmation',
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <strong>@lang('views.user_group'):</strong>
                        <select name="group" class="selectpicker" title="Select user role">
                            <option value="">Author</option>
                            <option value="1">Super Administrator</option>
                            <option value="2">Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <strong>@lang('views.status'):</strong>
                        <select name="status" class="selectpicker" title="">
                            <option value="0">Disabled</option>
                            <option value="1" selected>Enabled</option>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    @include('laravel-form-partials::select', [
                          'title' => __('general.country'),
                          'name' => 'country_id',
                          'placeholder' => __('views.select_country'), 
                          'records' => $countries,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('laravel-form-partials::textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => __('general.to_be_approved'), 
                          'value' => old('description'),
                          'required' => true,
                    ])
                </div>
            </div>

            @include('laravel-form-partials::buttons-back-submit', [
                  'route' => 'users.index'  
            ])

        </form>
    </div>
@endsection
