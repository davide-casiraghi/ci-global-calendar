@extends('donationOffers.layout')

@section('title'){{ $donationOffer->name }}@endsection
@section('description')Venue profile @ Global CI calendar @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            {{ $donationOffer->name }} {{ $donationOffer->surname }}
        </div>
        <div class="col-12">
            {{ $donationOffer->email }}
        </div>
        <div class="col-12">
            {{ $donationOffer->country_id }}
        </div>
        
        @if(!empty($donationOffer->gift_kind))
            <div class="col-12">
                {{ $donationOffer->contact_trough_voip }}
            </div>
        @endif
        
        <div class="col-12">
            {{ $donationOffer->language_spoken }}
        </div>
        <div class="col-12">
            {{ $donationOffer->offer_kind }}
        </div>
        
        @if(!empty($donationOffer->gift_kind))
            <div class="col-12">
                {{ $donationOffer->gift_kind }}
            </div>
        @endif
        
        @if(!empty($donationOffer->gift_description))
            <div class="col-12">
                {{ $donationOffer->gift_description }}
            </div>
        @endif
        
        @if(!empty($donationOffer->volunteer_kind))
            <div class="col-12">
                {{ $donationOffer->volunteer_kind }}
            </div>
        @endif
        
        @if(!empty($donationOffer->volunteer_description))
            <div class="col-12">
                {{ $donationOffer->volunteer_description }}
            </div>
        @endif
        
        @if(!empty($donationOffer->volunteer_description))
            <div class="col-12">
                {{ $donationOffer->other_description }}
            </div>
        @endif
        
        @if(!empty($donationOffer->suggestions))
            <div class="col-12">
                {{ $donationOffer->suggestions }}
            </div>
        @endif
        
        <div class="col-12">
            {{ $donationOffer->status }}
        </div>
        

        <div class="col-12">
            @if(!empty($eventVenue->address)) {{ $eventVenue->address }}<br /> @endif
            @if(!empty($eventVenue->city)) {{ $eventVenue->city }}<br /> @endif
            @if(!empty($eventVenue->state_province)) {{ $eventVenue->state_province }}<br /> @endif
            @if(!empty($country->name)) {{ $country->name }}<br /> @endif
            @if(!empty($eventVenue->zip_code)) {{ $eventVenue->zip_code }} @endif
        </div>

        @if(!empty($eventVenue->description))
            <div class="col-12 mt-4">
                <h3>Description</h3>
                {!! $eventVenue->description !!}
            </div>
        @endif

        @if(!empty($eventVenue->website))
            <div class="col-12 mt-4">
                <strong>Website</strong><br />
                <a href="{{ $eventVenue->website }}" target="_blank">{{ $eventVenue->website }}</a>
            </div>
        @endif




    </div>


@endsection
