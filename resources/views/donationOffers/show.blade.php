@extends('donationOffers.layout')

@section('title'){{ $donationOffer->name }}@endsection
@section('description')Venue profile @ Global CI calendar @endsection

@section('content')
    <div class="container max-w-md px-0">

        <div class="row m-0">
            <div class="col-12 mb-3">
                <h4>Donation details</h4>
            </div> 
        </div> 

        {{-- Donation details --}}
        <div class="row m-0 p-4 white-bg rounded mt-3">
            <div class="col-6 col-sm-3 mb-3 mb-sm-0 order-1">
                <i class="{{App\DonationOffer::getDonationKindArray()[$donationOffer->offer_kind]['icon']}} mr-1 dark-gray text-7xl"></i>
            </div>
            <div class="col-6 col-sm-2 pt-1 text-center order-2 order-sm-3">
                {!!App\DonationOffer::getDonationStatusBadge($donationOffer->status)!!}
            </div>
            <div class="col-12 col-sm-7 order-3 order-sm-2">
                <div class="row">
                    <div class="col-12">
                        <h5>{{App\DonationOffer::getDonationKindArray()[$donationOffer->offer_kind]['label']}}</h5>
                    </div>
                    
                    @if(!empty($donationOffer->gift_kind))
                        <div class="col-12 mb-3">
                            {{App\DonationOffer::getGiftKindArray()[$donationOffer->gift_kind]}}
                        </div>
                    @endif
                    @if(!empty($donationOffer->gift_description))
                        <div class="col-12">
                            {!! $donationOffer->gift_description !!}
                        </div>
                    @endif
                    
                    @if(!empty($donationOffer->volunteer_kind))
                        <div class="col-12">
                            <h5 class="mb-1">I want to collaborate as</h5>
                            {{App\DonationOffer::getVolunteeringKindArray()[$donationOffer->volunteer_kind]}}
                        </div>
                    @endif
                    
                    @if(!empty($donationOffer->volunteer_description))
                        <div class="col-12 mt-3">
                            {{ $donationOffer->volunteer_description }}
                        </div>
                    @endif
                    
                    @if(!empty($donationOffer->other_description))
                        <div class="col-12 mt-3">
                            {{ $donationOffer->other_description }}
                        </div>
                    @endif
                    
                    @if(!empty($donationOffer->suggestions))
                        <div class="col-12 mt-3">
                            <h5>Suggestions</h5>
                            {{ $donationOffer->suggestions }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Donor details --}}
        <div class="row m-0 p-4 white-bg rounded mt-3">
            
            <div class="col-12">
                <h5>Contact details</h5>
            </div>
            
            {{-- Name and Country --}}
            <div class="col-6">
                <b>{{ $donationOffer->name }} {{ $donationOffer->surname }}</b>
            </div>
            <div class="col-6">
                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                {{ $country->name }}           
            </div>
            
            {{-- Contacts details --}}
                <div class="col-6">
                    <a href="mailto:{{ $donationOffer->email }}">{{ $donationOffer->email }}</a>
                </div>
                
                <div class="col-6">
                    @if(!empty($donationOffer->contact_trough_voip))
                        <div class="row">
                            <div class="col-12">
                                <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-microphone mr-1 dark-gray" data-original-title="@lang('donations.voip')"></i>
                                {!! $donationOffer->contact_trough_voip !!}
                            </div>
                        </div>
                        
                        
                    @endif
                </div>
            
            <div class="col-12 mt-3">
                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-language mr-1 dark-gray" data-original-title="@lang('donations.language_spoken_show')"></i>
                {!! $donationOffer->language_spoken !!}
            </div>
        </div>
        
    </div>

@endsection
