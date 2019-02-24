


<div class="form-group radioCards">
    <strong>{{$title}}</strong>
    {{--<select name="offer_kind" class="selectpicker" title="@lang('views.choose')">
        <option value="1">@lang('views.donation_kind_financial')</option>
        <option value="2">@lang('views.donation_kind_gift')</option>
        <option value="3">@lang('views.donation_kind_volunteer')</option>
        <option value="4">@lang('views.donation_kind_other')</option>
    </select>--}}
    <div class="row mt-2">
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded p-2 w-100 h-100" for="offerFinancial">
                <input id="offerFinancial" class="form-check-input d-none" type="radio" name="offer_kind" value="1" />
                <i class="far fa-hand-holding-usd text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('views.donation_kind_financial')</span>
            </label>
        </div>
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded p-2 w-100 h-100"for="offerGift">
                <input id="offerGift" class="form-check-input d-none" type="radio" name="offer_kind" value="2" />
                <i class="far fa-gift text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('views.donation_kind_gift')</span>
            </label>
        </div>
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded p-2 w-100 h-100"for="offerVolunteer">
                <input id="offerVolunteer" class="form-check-input d-none" type="radio" name="offer_kind" value="3" />
                <i class="far fa-hands-helping text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('views.donation_kind_volunteer')</span>
            </label>
        </div>
        <div class="col-6 col-sm-3 col-md-6 col-lg-3 mb-2 text-center form-check">
            
            <label class="form-check-label bg-white shadow-1 rounded p-2 w-100 h-100"for="offerOther">
                <input id="offerOther" class="form-check-input d-none" type="radio" name="offer_kind" value="4" />
                <i class="far fa-hands-heart text-xl"></i>
                <span class="dark-gray text-xs d-block text-uppercase mt-2">@lang('views.donation_kind_other')</span>
            </label>
        </div>
    </div>
    
</div>
