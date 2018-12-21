{{--
    This modal is used in the event.create and event.edit view to add a new teacher
    It is loaded in view/partials/forms/modal-frame when the 
    button "Add new organizer" is clicked in the event create view
--}}


@extends('layouts.modal')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.add_new_organizer')</h2>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('organizers.storeFromModal') }}" method="POST">
        @csrf

        <div class="row">
           <div class="col-12">
               @include('partials.forms.input', [
                   'title' => __('general.name'),
                   'name' => 'name',
                   'placeholder' => 'Name'
               ])
           </div>
           
           <div class="col-12">
               @include('partials.forms.input', [
                   'title' => __('general.email_address'),
                   'name' => 'email'
               ])
           </div>
           <div class="col-12">
               @include('partials.forms.input', [
                   'title' => __('general.phone'),
                   'name' => 'phone',
                   'placeholder' => ''
               ])
           </div>
           <div class="col-12">
               @include('partials.forms.input', [
                   'title' => __('views.website'),
                   'name' => 'website',
                   'placeholder' => 'https://...'
               ])
           </div>
           <div class="col-12">
               @include('partials.forms.textarea', [
                     'title' => __('general.description'),
                     'name' => 'description',
                     'placeholder' => 'Organizer description'
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
