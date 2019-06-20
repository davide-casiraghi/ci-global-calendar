

<div class="container max-w-md px-0">
    <div class="row">
        <div class="col-12">
            <h4>@lang('donations.gift_list')</h4>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- List of gifts --}}
    <div class="giftsList row my-4">
        @foreach ($donationOffers as $key => $donationOffer)
            aas
            

        @endforeach
    </div>
</div>
