{{--
    This modal is used in the event.create and event.edit view to add a new teacher
    It is loaded in view/partials/forms/modal-frame when the 
    button "Add new venue" is clicked in the event create view
--}}

@extends('laravel-events-calendar::layouts.modal')

@section('javascript-document-ready')
    @parent
    
    $('#eventVenueModalForm').validate({
        rules: {
            name: "required",
            city: "required",
            country_id: "required",
            website: {
                required: false,
                url: true
            }
        },
        submitHandler: function(form) {
            //alert("Do some stuff... 2");
            $.ajax({
                url: '/create-venue/modal/',
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: $("input[name='name']").val(),
                    created_by: $("select[name='created_by']").val(),
                    city: $("input[name='city']").val(),
                    country_id: $("select[name='country_id']").val(),
                    website: $("input[name='website']").val()
                },
                type: 'POST',
                success: function(res) {
                    console.log("event venue created succesfully");
                    console.log(res.eventVenueId);
                    $('.modalFrame').modal('hide');
                    
                    $("select#eventVenue").append('<option value="'+res.eventVenueId+'" selected="">'+res.eventVenueName+'</option>');
                    $("select#eventVenue").selectpicker("refresh");
                    
                    //$("input[name='multiple_organizers']").val($("input[name='multiple_organizers']").val() + ", " + res.eventVenueId);
                },
                error: function(error) {
                    //$('.modalFrame').modal('hide');
                    console.log(error);
                }          
            });
        }
    });
    
    {{-- Update Region SELECT on change Country SELECT --}}
    $("select[name='country_id']").on('change', function() {
        if (this.value != ''){
            updateRegionsDropdown(this.value);
        }
    });
    
    {{-- Update the Regions SELECT with just the ones 
             relative to the selected country --}}
    function updateRegionsDropdown(selectedCountry){
        var request = $.ajax({
            url: "/update_regions_dropdown",
            data: {
                country_id: selectedCountry,
            },
            success: function( data ) {
                $("#region_id").html(data);
                $("#region_id").selectpicker('refresh');
            }
        });
    }
    
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="col-12 pb-3">
            <h4>@lang('laravel-events-calendar::eventVenue.add_new_venue')</h4>
        </div>
    </div>

    @include('laravel-form-partials::error-management', [
          'style' => 'alert-danger',
    ])

    <form id="eventVenueModalForm" action="{{ route('eventVenues.storeFromModal') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => __('laravel-events-calendar::general.name'),
                    'name' => 'name',
                    'placeholder' => 'Name',
                    'required' => true,
                ])
            </div>
            
            {{-- Created by - hidden --}}
            <div class="col-12 d-none">
                @include('laravel-form-partials::select', [
                    'title' => __('laravel-events-calendar::general.created_by'),
                    'name' => 'created_by',
                    'placeholder' => __('laravel-events-calendar::general.select_owner'),
                    'records' => $users,
                    'liveSearch' => 'true',
                    'mobileNativeMenu' => false,
                    'selected' => Auth::id(),
                    'required' => false,
                ])
            </div>
            
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => __('laravel-events-calendar::eventVenue.street'),
                    'name' => 'address',
                    'placeholder' => '',
                    'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => __('laravel-events-calendar::eventVenue.city'),
                    'name' => 'city',
                    'placeholder' => '',
                    'required' => true,
                ])
            </div>
            {{--<div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => __('laravel-events-calendar::eventVenue.state_province'),
                    'name' => 'state_province',
                    'placeholder' => '',
                    'required' => false,
                ])
            </div>--}}
            <div class="col-12">
                @include('laravel-form-partials::select', [
                      'title' => __('laravel-events-calendar::eventVenue.country'),
                      'name' => 'country_id',
                      'placeholder' => 'Select country',
                      'records' => $countries,
                      'liveSearch' => 'true',
                      'mobileNativeMenu' => false,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::select', [
                      'title' => __('laravel-events-calendar::eventVenue.region'),
                      'name' => 'region_id',
                      'placeholder' => __('laravel-events-calendar::general.select_region'), 
                      'records' => $regions,
                      'liveSearch' => 'true',
                      'mobileNativeMenu' => false,
                      'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => __('laravel-events-calendar::eventVenue.zip_code'),
                    'name' => 'zip_code',
                    'placeholder' => '',
                    'value' => '',
                    'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' => __('laravel-events-calendar::general.website'),
                    'name' => 'website',
                    'placeholder' => 'https://...',
                    'value' => '',
                    'required' => false,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::textarea-plain', [
                    'title' => __('laravel-events-calendar::general.description'),
                    'name' => 'description',
                    'placeholder' => '',
                    'required' => false,
                ])
            </div>
       </div>

       <div class="row mt-5">
           <div class="col-6 pull-left">
               <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('laravel-events-calendar::general.close')</button>
           </div>
           <div class="col-6 pull-right">
               <button type="submit" class="btn btn-primary float-right">@lang('laravel-events-calendar::general.submit')</button>
           </div>
       </div>

    </form>

@endsection
