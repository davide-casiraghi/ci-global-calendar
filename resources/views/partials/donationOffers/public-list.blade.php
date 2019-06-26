
<div class="container max-w-md px-0">
    <div class="row">
        <div class="col-12">
            <h4>
                @lang('donations.available_gifts_list')
            </h4>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- List of gifts --}}
    <div class="giftsList my-4">
        @foreach ($donationOffers as $key => $donationOffer)
            
        @if($donationOffer->offer_kind == 2 || $donationOffer->offer_kind == 4)
            
            <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                <div class="col-12 py-1">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="d-inline darkest-gray mr-2">{{$donationOffer->gift_title}}</h5> - 
                            @if ($donationOffer->offer_kind == 2)
                                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-ticket-alt ml-2 mr-2 dark-gray" data-original-title="@lang('donations.donation_kind_free_entrance')"></i>
                            @else
                                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-gift ml-2 mr-2 dark-gray" data-original-title="@lang('donations.donation_kind_other_gift')"></i>
                            @endif
                            
                            
                            
                            - <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas ml-2 dark-gray" data-original-title="@lang('general.country')"></i>
                            @if($donationOffer->country_id){{ $countries[$donationOffer->country_id] }}@endif
                        </div>
                        <div class="col-2 pt-1">
                            {!!App\DonationOffer::getDonationStatusBadge($donationOffer->status)!!}
                        </div>
                    </div>
                    
                    <div class="row my-2">    
                        <div class="col-6">
                            <i data-toggle="tooltip" data-placement="top" title="" class="far fa-money-bill-wave-alt mr-1 dark-gray" data-original-title="@lang('donations.gift_economic_value')"></i>
                            {{$donationOffer->gift_economic_value}}
                            
                            <i data-toggle="tooltip" data-placement="top" title="" class="far fa-clock mr-1 ml-4 dark-gray" data-original-title="@lang('donations.volunteer_time_value')"></i>
                            {{$donationOffer->gift_volunteer_time_value}}
                        </div>
                        
                    </div>  
                </div>
                
                <div class="col-12 pb-2 action">    
                    <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('donationOffers.show',$donationOffer->id) }}">@lang('views.view')</a>
                </div>
            </div>    
            
        @endif

        @endforeach
    </div>
</div>
