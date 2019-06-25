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
                
        @switch($page_kind)
            @case(4) {{-- other_gifts --}}
                @include('partials.donationOffers.other-gifts-list')
            @break

            @case(2) {{-- free_entrances --}}
                @include('partials.donationOffers.free-entrances-list')
            @break

            @case(1) {{-- financial --}}
                @include('partials.donationOffers.financial-contributions-list')
            @break
                
            @case(3) {{-- volunteers --}} 
                @include('partials.donationOffers.volunteers-list')
            @break
            
            @case('public')
                @include('partials.donationOffers.public-list')
            @break
        @endswitch

        {{--@if(Route::current()->getName() == 'donationOffers.freeEntrances') 
            @include('partials.donationOffers.freeEntrances-list')
        @endif
    
        @if(Route::current()->getName() == 'donationOffers.otherGifts') 
            @include('partials.donationOffers.gifts-list')
        @endif
        
        @if(Route::current()->getName() == 'donationOffers.financial') 
            @include('partials.donationOffers.financialContributions-list')
        @endif
        
        @if(Route::current()->getName() == 'donationOffers.volunteers') 
            @include('partials.donationOffers.volunteers-list')
        @endif
        
        --}}

@endsection
