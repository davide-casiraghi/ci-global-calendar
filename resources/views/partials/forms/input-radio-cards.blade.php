
{{--
    INPUT radio form field
    Display some radios as graphic cards with icons and legend
    
    PARAMETERS:
        - $title: string - the title to show above the radio button list
        
--}}


@section('javascript-document-ready')
    @parent
        
    {{-- Show the area corresponding to the card on opening --}}
        var selectedOfferKind = $('input[name=offer_kind]:checked');
        showCardDetails(selectedOfferKind);
        //$(".donation-choice-" + selectedOfferKind).removeClass('d-none');
    
    {{-- Update radio Card background on click (Active state), and show the corresponding area. --}}
        $("input[type=radio][name='offer_kind']").change(function(){
            showCardDetails(this);
        });
        
        function showCardDetails(selectedOfferKind) {
            
            $( ".donation-choice" ).addClass('d-none');
            $( ".entrance-bar-visibility" ).addClass('d-none');
            $( ".other-gift-bar-visibility" ).addClass('d-none');
            $( ".entrance-kind-visibility" ).addClass('d-none');
            
            $('.radioCards label').removeClass('active');
            $(selectedOfferKind).parent('label').addClass('active');
            
            switch(selectedOfferKind.val()) {    
                case '1': // Financial
                    $(".donation-choice-1").removeClass('d-none');
                break;
                case '2': // Free entrance
                    $(".donation-choice-3").removeClass('d-none');
                    $( ".entrance-bar-visibility" ).removeClass('d-none');
                    $( ".entrance-kind-visibility" ).removeClass('d-none');            
                break;
                case '3': // Volunteer
                    $(".donation-choice-2").removeClass('d-none');
                break;
                case '4': // Other gift
                    $(".donation-choice-3").removeClass('d-none');
                    $( ".other-gift-bar-visibility" ).removeClass('d-none');
                break;
            }
        }
    
@stop

<div class="form-group radioCards">
    <strong>{{$title}}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</strong>
    
    <div class="row mt-2">
        @foreach ($records as $value => $record)
            <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
                <label class="form-check-label bg-white shadow-1 rounded px-1 py-2 w-100 h-100 @if(!empty($selected)) {{ $selected == $value ? 'active' : '' }} @endif " for="{{$record['id']}}">
                    <input id="{{$record['id']}}" class="form-check-input d-none" type="radio" name="offer_kind" value="{{$value}}" @if(!empty($selected)) {{ $selected == $value ? 'checked' : '' }} @endif />
                    <i class="{{$record['icon']}} text-xl"></i>
                    <span class="dark-gray text-xs d-block text-uppercase mt-2">{{$record['label']}}</span>
                    <div class="active-icon"></div>
                </label>
            </div>
        @endforeach
    </div>
    
</div>
