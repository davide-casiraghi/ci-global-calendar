@extends('massMailingForms.layout')

@section('content')
    <div class="container max-w-sm px-0">

        <div class="row">
            <div class="col-12 ">
                <h3>Mass Mailing</h3>
            </div>
        </div>

        <form action="{{ route('forms.massmailing-send') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-12 mt-3 mb-2">
                    <div class='alert alert-warning' role='alert'>
                        @lang('views.mass_mailing_warning')
                    </div>
                </div>

               <div class="col-12">
                   @include('laravel-form-partials::textarea-plain', [
                         'title' => __('general.message'),
                         'name' => 'message',
                         'placeholder' => '',
                         'required' => true,
                   ])
               </div>
               
               <div class="col-12">
                   {{-- Recaptcha google v2 --}}
                   @include('laravel-form-partials::recaptcha')
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
   </div>
@endsection
