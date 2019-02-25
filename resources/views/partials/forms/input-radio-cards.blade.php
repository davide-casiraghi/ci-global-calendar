
{{--
    INPUT radio form field
    Display some radios as graphic cards with icons and legend
    
    PARAMETERS:
        - $title: string - the title to show above the radio button list
        
--}}


@section('javascript-document-ready')
    @parent
    
    {{-- Show the area corresponding to the card on opening --}}
        var selectedOfferKind = $('input[name=offer_kind]:checked').val();
        $(".donation-choice-" + selectedOfferKind).removeClass('d-none');
    
    {{-- Update radio Card background on click (Active state), and show the corresponding area. --}}
        $("input[type=radio][name='offer_kind']").change(function(){
            $( ".donation-choice" ).addClass('d-none');
            
            $('.radioCards label').removeClass('active');
            $(this).parent('label').addClass('active');
            
            switch(this.value) {    
                case '1':
                    $(".donation-choice-1").removeClass('d-none');
                break;
                case '2':
                    $(".donation-choice-2").removeClass('d-none');
                break;
                case '3':
                    $(".donation-choice-3").removeClass('d-none');
                break;
                case '4':
                    $(".donation-choice-4").removeClass('d-none');
                break;
            }
        });
    
@stop

<div class="form-group radioCards">
    <strong>{{$title}}</strong>
    
    <div class="row mt-2">
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded px-1 py-2 w-100 h-100 @if(!empty($selected)) {{ $selected == 1 ? 'active' : '' }} @endif " for="offerFinancial">
                <input id="offerFinancial" class="form-check-input d-none" type="radio" name="offer_kind" value="1" @if(!empty($selected)) {{ $selected == 1 ? 'checked' : '' }} @endif />
                <i class="far fa-hand-holding-usd text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('donations.donation_kind_financial')</span>
                <div class="active-icon"></div>
            </label>
        </div>
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded px-1 py-2 w-100 h-100 @if(!empty($selected)) {{ $selected == 2 ? 'active' : '' }} @endif "for="offerGift">
                <input id="offerGift" class="form-check-input d-none" type="radio" name="offer_kind" value="2" @if(!empty($selected)) {{ $selected == 2 ? 'checked' : '' }} @endif />
                <i class="far fa-gift text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('donations.donation_kind_gift')</span>
                <div class="active-icon"></div>
            </label>
        </div>
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded px-1 py-2 w-100 h-100 @if(!empty($selected)) {{ $selected == 3 ? 'active' : '' }} @endif "for="offerVolunteer">
                <input id="offerVolunteer" class="form-check-input d-none" type="radio" name="offer_kind" value="3" @if(!empty($selected)) {{ $selected == 3 ? 'checked' : '' }} @endif />
                <i class="far fa-hands-helping text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('donations.donation_kind_volunteer')</span>
                <div class="active-icon"></div>
            </label>
        </div>
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded px-1 py-2 w-100 h-100 @if(!empty($selected)) {{ $selected == 4 ? 'active' : '' }} @endif "for="offerOther">
                <input id="offerOther" class="form-check-input d-none" type="radio" name="offer_kind" value="4" @if(!empty($selected)) {{ $selected == 4 ? 'checked' : '' }} @endif />
                <i class="far fa-hands-heart text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('donations.donation_kind_other')</span>
                <div class="active-icon"></div>
            </label>
        </div>
    </div>
    
</div>
