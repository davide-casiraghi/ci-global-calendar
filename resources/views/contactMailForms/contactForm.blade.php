@extends('contactMailForms.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                @switch($recipient)
                    @case("administrator")
                        <h2>@lang('views.contact_the_administrator')</h2>
                    @break

                    @case("project-manager")
                        <h2>@lang('views.contact_the_project_manager')</h2>
                    @break
                    
                    @case("webmaster")
                        <h2>@lang('views.contact_the_webmaster')</h2>
                    @break

                    @case("test")
                        <h2>Contact test</h2>
                    @break
                @endswitch

            </div>
        </div>
    </div>

    <form action="{{ route('forms.contactform-send') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12 mt-3 mb-5">
                @lang('views.please_write_in_english')
            </div>

            <div class="col-12">
               @include('partials.forms.input', [
                     'title' => __('general.name'),
                     'name' => 'name',
                     'placeholder' => '',
                     'required' => true,
               ])
            </div>

           <div class="col-12">
               @include('partials.forms.input', [
                     'title' => __('general.email_address'),
                     'name' => 'email',
                     'placeholder' => '',
                     'required' => true,
               ])
           </div>

           <div class="col-12">
               @include('partials.forms.textarea-plain', [
                     'title' => __('general.message'),
                     'name' => 'message',
                     'placeholder' => '',
                     'required' => true,
               ])
           </div>
           
           <div class="col-12">
               {{-- Recaptcha google v2 --}}
               @include('partials.forms.recaptcha')
           </div>
           
           @include('partials.forms.input-hidden', [
                 'name' => 'recipient',
                 'value' => $recipient
           ])

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
