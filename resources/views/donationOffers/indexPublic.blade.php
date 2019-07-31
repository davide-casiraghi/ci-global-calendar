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
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h4>@lang('donations.gift_list')</h4>
            </div>
            <div class="col-12 col-sm-5 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('donationOffers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('donations.create_new_donation_offer')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif


        {{-- Search form --}}
        <form class="searchForm mt-3" action="{{ route('donationOffers.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_user_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-6  pr-sm-2">
                    @include('laravel-form-partials::select', [
                        'name' => 'country_id',
                        'placeholder' => __('views.filter_by_country'),
                        'records' => $countries,
                        'selected' => $searchCountry,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                    ])
                </div>
                <div class="col-12 col-sm-6">
                    @include('laravel-form-partials::select', [
                        'name' => 'donation_kind_filter',
                        'placeholder' => __('donations.filter_by_donation_kind'),
                        'records' => $donationKindArray,
                        'selected' => $searchDonationKind,
                        'liveSearch' => 'false',
                        'mobileNativeMenu' => true,
                    ])
                </div>
                <div class="col-12">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>

        {{-- List of donations --}}
        <div class="venuesList my-4">
            @foreach ($donationOffers as $donationOffer)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    <div class="col-12 py-1 title">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="darkest-gray">{{ $donationOffer->name }} {{ $donationOffer->surname }}</h5>
                            </div>
                            <div class="col-4 pt-1">
                                {!!App\DonationOffer::getDonationStatusBadge($donationOffer->status)!!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                        @if($donationOffer->country_id){{ $countries[$donationOffer->country_id] }}@endif
                            
                        <i data-toggle="tooltip" data-placement="top" title="" class="{{App\DonationOffer::getDonationKindArray()[$donationOffer->offer_kind]['icon']}} mr-1 ml-4 dark-gray" data-original-title="@lang('donations.donation_kind')"></i>
                        {{App\DonationOffer::getDonationKindArray()[$donationOffer->offer_kind]['label']}}
                    </div>
                    <div class="col-12 pb-2 action">
                        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('donationOffers.show',$donationOffer->id) }}">@lang('views.view')</a>
                    </div>
                    
                </div>    
                
            @endforeach    
        </div>

        {!! $donationOffers->links() !!}
    </div>

@endsection
