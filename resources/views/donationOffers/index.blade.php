@extends('donationOffers.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $("select[name=donation_kind_filter] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@stop

@section('content')
    
        @if(Route::current()->getName() == 'donationOffers.gifts') 
            @include('partials.donationOffers.gifts-list')
        @endif
        
        @if(Route::current()->getName() == 'donationOffers.financial') 
            @include('partials.donationOffers.financialContributions-list')
        @endif
        
        @if(Route::current()->getName() == 'donationOffers.volunteers') 
            @include('partials.donationOffers.volunteers-list')
        @endif

@endsection
