@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('menu.create_account')</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        {{--  NAME --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- MAIL --}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--  PASSWORD --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- confirm PASSWORD --}}
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        {{-- COUNTRY --}}
                        <div class="form-group row">
                            <label for="country_id" class="col-md-4 col-form-label text-md-right">@lang('general.country')</label>

                            <div class="col-md-6">
                                @include('partials.forms.select', [
                                      'title' => '',
                                      'name' => 'country_id',
                                      'placeholder' => 'Select country',
                                      'records' => $countries
                                ])
                            </div>
                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">@lang('general.description')</label>

                            <div class="col-md-6">
                                @include('partials.forms.textarea-plain', [
                                      'title' => '',
                                      'name' => 'description',
                                      'placeholder' => 'To be approved as an editor of the CI Global Calendar, please describe your role in the Contact Improvisation community. (this is needed to prevent spam contents in the website)',
                                      'height' => '11rem'
                                ])
                            </div>
                        </div>

                        {{-- ACCEPT  --}}
                        <div class="form-group row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-6">
                                @include('partials.forms.checkbox', [
                                      'name' => 'accept_terms',
                                      'description' => __('general.accept_terms_of_use')
                                ])
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
