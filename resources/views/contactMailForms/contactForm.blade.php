@extends('contactMailForms.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.contact_the_administrator')</h2>
            </div>
        </div>
    </div>

    <form action="{{ route('forms.contact-admin-send') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12 mt-3 mb-5">
                @lang('views.please_write_in_english')
            </div>

            <div class="col-12">
               @include('partials.forms.input', [
                     'title' => __('general.name'),
                     'name' => 'name',
                     'placeholder' => ''
               ])
            </div>

           <div class="col-12">
               @include('partials.forms.input', [
                     'title' => __('general.email_address'),
                     'name' => 'email',
                     'placeholder' => ''
               ])
           </div>

           <div class="col-12">
               @include('partials.forms.textarea-plain', [
                     'title' => __('general.message'),
                     'name' => 'message',
                     'placeholder' => ''
               ])
           </div>

       </div>

       <div class="row mt-5">
           <div class="col-6 pull-left">
               <a class="btn btn-primary" href="{{ route('home') }}">@lang('general.back')</a>
           </div>
           <div class="col-6 pull-right">
             <button type="submit" class="btn btn-primary float-right">@lang('general.send')</button>
           </div>
       </div>
   </form>

@endsection
