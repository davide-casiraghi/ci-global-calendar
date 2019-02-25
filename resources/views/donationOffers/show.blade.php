@extends('donationOffers.layout')

@section('title'){{ $donationOffer->name }}@endsection
@section('description')Venue profile @ Global CI calendar @endsection

@section('content')

    <div class="row">
        
        <div class="col-12">
            <h4>Donor details</h4>
            <b>Name:</b> {{ $donationOffer->name }} <br />
            <b>Surname:</b> {{ $donationOffer->surname }}
        </div>
        <div class="col-12">
            <b>Email:</b> {{ $donationOffer->email }}
        </div>
        <div class="col-12">
            {{ $country->name }}
        </div>
        
        @if(!empty($donationOffer->contact_trough_voip))
            <div class="col-12">
                <b>Contact trough voip:</b>
                {!! $donationOffer->contact_trough_voip !!}
            </div>
        @endif
        
        <div class="col-12">
            <b>Language spoken:</b>
            {!! $donationOffer->language_spoken !!}
        </div>
        <div class="col-12">
            <b>Offer Kind:</b>
            {{App\DonationOffer::getDonationKindArray()[$donationOffer->offer_kind]['label']}}
        </div>
        
        @if(!empty($donationOffer->gift_kind))
            <div class="col-12">
                {{ $donationOffer->gift_kind }}
            </div>
        @endif
        
        @if(!empty($donationOffer->gift_description))
            <div class="col-12">
                <b>Gift description</b>
                {!! $donationOffer->gift_description !!}
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
            Status: {{ $donationOffer->status }}
        </div>
        

    </div>


@endsection
