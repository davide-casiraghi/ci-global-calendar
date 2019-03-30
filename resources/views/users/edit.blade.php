@extends('users.layout')


@section('content')
    <div class="container max-w-sm px-0">
        
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('views.edit_user')</h4>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('users.update',$user->id) }}" method="POST">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => __('views.user_name'),
                          'value' => $user->name,
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.email_address'),
                          'name' => 'email',
                          'value' => $user->email,
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.password', [
                          'title' => __('general.password'),
                          'name' => 'password',
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.password', [
                          'title' => __('general.confirm_password'),
                          'name' => 'password_confirmation',
                          'required' => true,
                    ])
                </div>

                @if( $logged_user_group == 1 || $logged_user_group == 2)
                    <div class="col-12">
                        <div class="form-group">
                            <strong>@lang('views.user_group'):</strong>
                            <select name="group" class="selectpicker" title="Select user group">
                                <option value="" @if(empty($user->group)) {{'selected'}} @endif >Author</option>
                                <option value="1" @if(!empty($user->group)) {{  $user->group == '1' ? 'selected' : '' }} @endif>Super Administrator</option>
                                <option value="2" @if(!empty($user->group)) {{  $user->group == '2' ? 'selected' : '' }} @endif>Administrator</option>
                            </select>
                        </div>
                    </div>
                @endif

                @if( $logged_user_group == 1 || $logged_user_group == 2)
                    <div class="col-12">
                        <div class="form-group">
                            <strong>@lang('views.status'):</strong>
                            <select name="status" class="selectpicker" title="">
                                <option value="0" @if(empty($user->status)) {{ 'selected' }} @endif>@lang('views.disabled')</option>
                                <option value="1" @if(!empty($user->status)) {{ 'selected' }} @endif>@lang('views.enabled')</option>
                            </select>
                        </div>
                    </div>
                @else
                    @include('partials.forms.input-hidden', [
                          'name' => 'status',
                          'value' => $user->status,
                    ])
                @endif

                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => __('general.country'),
                          'name' => 'country_id',
                          'placeholder' => __('views.select_country'), 
                          'records' => $countries,
                          'seleted' => $user->country_id,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.textarea', [
                          'title' => __('general.description'),
                          'name' => 'description',
                          'placeholder' => __('general.to_be_approved'), 
                          'value' => $user->description,
                          'required' => true,
                    ])
                </div>

            </div>

            @include('partials.forms.buttons-back-submit', [
                  'route' => 'users.index'  
            ])

        </form>
    </div>
@endsection
