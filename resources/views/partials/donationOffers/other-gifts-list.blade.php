
<div class="container max-w-md px-0">
    <div class="row">
        <div class="col-12">
            <h4>
                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-gift ml-2 mr-2 dark-gray"></i>
                @lang('donations.gift_list')
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
            
        @if($donationOffer->offer_kind == 4)
            
            <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                <div class="col-12 py-1">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="d-inline darkest-gray mr-2">{{$donationOffer->gift_title}}</h5>
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
                        <div class="col-6 text-right">
                            @if($donationOffer->gift_given_to)
                                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-user mr-1 ml-4 dark-gray" data-original-title="@lang('donations.assigned_to')"></i>
                                {{$donationOffer->gift_given_to}}
                            @endif
                            @if($donationOffer->gift_given_when)
                                <i data-toggle="tooltip" data-placement="top" title="" class="far fa-calendar-alt mr-1 ml-4 dark-gray" data-original-title="@lang('donations.assigned_when')"></i>
                                @date($donationOffer->gift_given_when)
                            @endif
                        </div>
                    </div>  
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('donationOffers.destroy',$donationOffer->id) }}" method="POST">

                        <a class="btn btn-primary float-right" href="{{ route('donationOffers.edit',$donationOffer->id) }}">@lang('views.edit')</a>
                        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('donationOffers.show',$donationOffer->id) }}">@lang('views.view')</a>
                        
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                    </form>
                </div>
            </div>    
            
        @endif

        @endforeach
    </div>
</div>
