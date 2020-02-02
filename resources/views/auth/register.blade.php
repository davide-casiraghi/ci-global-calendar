@extends('layouts.app')

@section('title')@lang('menu.create_account')@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('menu.create_account')</div>

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        {{--  NAME --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('general.name') *</label>

                            <div class="col-md-6">
                                @include('laravel-form-partials::input', [
                                      'title' => '',
                                      'name' => 'name',
                                      'placeholder' => '',
                                      'value' => old('name'),
                                      'required' => true,
                                ])
                            </div>
                        </div>

                        {{-- MAIL --}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('general.email_address') *</label>

                            <div class="col-md-6">
                                @include('laravel-form-partials::input', [
                                      'title' => '',
                                      'name' => 'email',
                                      'value' => old('email'),
                                      'required' => true,
                                ])
                            </div>
                        </div>

                        {{--  PASSWORD --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('general.password') *</label>

                            <div class="col-md-6">
                                @include('laravel-form-partials::password', [
                                      'title' => '',
                                      'name' => 'password',
                                      'required' => false,
                                ])
                            </div>
                        </div>

                        {{-- confirm PASSWORD --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('general.confirm_password') *</label>
                            
                            <div class="col-md-6">
                                @include('laravel-form-partials::password', [
                                      'title' => '',
                                      'name' => 'password_confirmation',
                                      'required' => false,
                                ])
                            </div>
                        </div>

                        {{-- COUNTRY --}}
                        <div class="form-group row">
                            <label for="country_id" class="col-md-4 col-form-label text-md-right">@lang('general.country')</label>

                            <div class="col-md-6">
                                @include('laravel-form-partials::select', [
                                      'title' => '',
                                      'name' => 'country_id',
                                      'placeholder' => __('general.select_country'),
                                      'records' => $countries,
                                      'liveSearch' => 'true',
                                      'selected' => old('country_id'),
                                      'mobileNativeMenu' => false,
                                ])
                            </div>
                        </div>


                        {{-- DESCRIPTION --}}
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">@lang('general.description') *</label>

                            <div class="col-md-6">
                                @include('laravel-form-partials::textarea-plain', [
                                      'title' => '',
                                      'name' => 'description',
                                      'placeholder' => __('general.to_be_approved'),
                                      'height' => '11rem',
                                      'value' => old('description'),
                                ])
                            </div>
                        </div>

                        {{-- ACCEPT TERMS --}}
                        <div class="form-group row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-6">
                                @include('laravel-form-partials::checkbox', [
                                      'name' => 'accept_terms',
                                      'description' => __('general.accept_terms_of_use'),
                                      'value' => old('accept_terms'),
                                ])
                                <a href="/post/terms-of-use">@lang('menu.terms_of_use') ></a>
                                
                            </div>
                        </div>
                        
                        {{-- Captcha --}}
                        <div class="form-group row mt-4">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-6">
                                {{--@include('laravel-form-partials::recaptcha')--}}
                                @php 
                                    $random_number1 = rand(1, 8);
                                    $random_number2 = rand(1, 8);
                                @endphp
                                @include('laravel-form-partials::recaptcha-sum-v2', [
                                    'name' => 'recaptcha_sum_1',
                                    'randomNumber1Name' => 'random_number_1',
                                    'randomNumber2Name' => 'random_number_2',
                                    'randomNumber1Value' => $random_number1,
                                    'randomNumber2Value' => $random_number2,
                                ])
                            </div>
                        </div>
                        
                
                        {{-- INFORMATION ABOUT ADMIN APPROVAL --}}
                        <div class="form-group row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-6">
                                @include('laravel-form-partials::alert', [
                                	'text' => __('general.admin_account_approval'),
                                	'style' => 'alert-warning',
                                ])
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary float-right">
                                    @lang('general.register')
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
