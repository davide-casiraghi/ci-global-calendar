@extends('users.layout')


@section('content')
    <div class="container max-w-sm px-0">
        
        <div class="row">
            <div class="col-12">
                <h3>@lang('views.add_new_user')</h3>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => '',
                          'value' => old('name')
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.email_address'),
                          'name' => 'email',
                          'value' => old('email')
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.password', [
                          'title' => __('general.password'),
                          'name' => 'password'
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.password', [
                          'title' => __('general.confirm_password'),
                          'name' => 'password_confirmation'
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
                    @include('partials.forms.select', [
                          'title' => __('general.country'),
                          'name' => 'country_id',
                          'placeholder' => __('views.select_country'), 
                          'records' => $countries,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => __('general.to_be_approved'), 
                          'value' => old('description')
                    ])
                </div>
            </div>

            @include('partials.forms.buttons-back-submit', [
                  'route' => 'users.index'  
            ])

        </form>
    </div>
@endsection
