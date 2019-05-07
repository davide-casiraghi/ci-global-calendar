{{--
    This modal is used in the event.create and event.edit view to add a new teacher
    It is loaded in view/partials/forms/modal-frame when the 
    button "Add new organizer" is clicked in the event create view
--}}

@extends('laravel-events-calendar::layouts.modal')

@section('content')
    <div class="row">
        <div class="col-12">
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="col-12 pb-3">
            <h4>@lang('views.add_new_organizer')</h4>
        </div>
    </div>

    @include('laravel-events-calendar::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('organizers.storeFromModal') }}" method="POST">
        @csrf

        <div class="row">
           <div class="col-12">
               @include('laravel-events-calendar::partials.input', [
                   'title' => __('general.name'),
                   'name' => 'name',
                   'placeholder' => 'Name',
                   'required' => true,
               ])
           </div>
           
           <div class="col-12">
               @include('laravel-events-calendar::partials.input', [
                   'title' => __('general.email_address'),
                   'name' => 'email',
                   'required' => true,
               ])
           </div>
           <div class="col-12">
               @include('laravel-events-calendar::partials.input', [
                   'title' => __('general.phone'),
                   'name' => 'phone',
                   'placeholder' => '',
                   'required' => false,
               ])
           </div>
           <div class="col-12">
               @include('laravel-events-calendar::partials.input', [
                   'title' => __('views.website'),
                   'name' => 'website',
                   'placeholder' => 'https://...',
                   'required' => false,
               ])
           </div>
           <div class="col-12">
               @include('laravel-events-calendar::partials.textarea', [
                     'title' => __('general.description'),
                     'name' => 'description',
                     'placeholder' => 'Organizer description',
                     'required' => false,
               ])
           </div>
       </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('general.close')</button>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">@lang('general.submit')</button>
            </div>
        </div>

    </form>

@endsection
