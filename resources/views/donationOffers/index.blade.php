@extends('donationOffers.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@stop

@section('content')
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h4>@lang('donations.donation_offers_management')</h4>
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
                <div class="col-12 col-sm-6 pr-sm-2">
                    @include('partials.forms.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_venue_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-6">
                    @include('partials.forms.select', [
                        'name' => 'country_id',
                        'placeholder' => __('views.filter_by_country'),
                        'records' => $countries,
                        'seleted' => $searchCountry,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                    ])
                </div>
                <div class="col-12">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>

        {{-- List of venues --}}
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
                            
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-hands-heart mr-1 ml-4 dark-gray" data-original-title="@lang('donations.donation_kind')"></i>
                        {{App\DonationOffer::getDonationKindString($donationOffer->offer_kind)}}
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
                
            @endforeach    
        </div>

        {!! $donationOffers->links() !!}
    </div>

@endsection
