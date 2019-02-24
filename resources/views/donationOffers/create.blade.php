@extends('donationOffers.layout')

@section('javascript-document-ready')
    @parent
    {{-- End date update after start date has changed, and doesn't allow to select a date before the start --}}
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

@section('content')
    <div class="container max-w-lg px-0">
        <div class="row pt-4">
            <div class="col-12">
                <h4>@lang('views.create_new_donation_offer')</h4>
            </div>
        </div>
        
        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])
        
        <hr class="mt-3 mb-4">
        
        <form action="{{ route('donationOffers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basics --}}
                <div class="row">
                    <div class="col-12 col-md form-sidebar">
                        <h5 class="text-xl">@lang('views.your_contact_details')</h5>
                        <span class="dark-gray">@lang('views.your_contact_details_desc')</span>
                    </div>
                    <div class="col-12 col-md main">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.name'),
                                      'name' => 'name',
                                      'placeholder' => '',
                                      'value' => old('name')
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.surname'),
                                      'name' => 'surname',
                                      'placeholder' => '',
                                      'value' => old('surname')
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.email_address'),
                                      'name' => 'email',
                                      'value' => old('email')
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea-plain', [
                                    'title' =>  __('views.contact_through_skype_or_another_voip'),
                                    'name' => 'contact_trough_voip',
                                    'value' => old('contact_trough_voip')
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.select', [
                                      'title' => __('general.country'),
                                      'name' => 'country_id',
                                      'placeholder' => __('views.select_country'), 
                                      'records' => $countries,
                                      'liveSearch' => 'true',
                                      'mobileNativeMenu' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea-plain', [
                                    'title' =>  __('views.language_spoken'),
                                    'name' => 'language_spoken',
                                    'value' => old('language_spoken')
                                ])
                            </div>
                            
                            
                            
                            {{-- Show the created by field just to the admin and super admin --}}
                            @if(empty($authorUserId))
                                <div class="col-12">
                                    @include('partials.forms.select', [
                                          'title' =>  __('views.created_by'), 
                                          'name' => 'created_by',
                                          'placeholder' => __('views.select_owner'),
                                          'records' => $users,
                                          'liveSearch' => 'true',
                                          'mobileNativeMenu' => false,
                                    ])
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            
                <hr class="mt-3 mb-4">
                
                {{-- How you want to help --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">@lang('views.i_want_to_help')</h5>
                            <span class="dark-gray">@lang('views.kind_of_help_description')</span>
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <strong>@lang('views.i_can_offer'):</strong>
                                        {{--<select name="offer_kind" class="selectpicker" title="@lang('views.choose')">
                                            <option value="1">@lang('views.donation_kind_financial')</option>
                                            <option value="2">@lang('views.donation_kind_gift')</option>
                                            <option value="3">@lang('views.donation_kind_volunteer')</option>
                                            <option value="4">@lang('views.donation_kind_other')</option>
                                        </select>--}}
                                        <div class="row mt-2 radioCards">
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
                                </div>
                                                                    
                            </div>
                        </div>
                    </div>
                    
                    {{--
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">@lang('views.i_want_to_help')</h5>
                            <span class="dark-gray">@lang('views.kind_of_help_description')</span>
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    <div class="cc-selector">
                                        <input id="offerFinancial" type="radio" name="offer_kind" value="1" />
                                        <label class="bg-white shadow-1 rounded p-2" for="offerFinancial">
                                            <i class="far fa-hand-holding-usd"></i>
                                        </label>
                                        <input id="offerGift" type="radio" name="offer_kind" value="2" />
                                        <label class="bg-white shadow-1 rounded p-2"for="offerGift">
                                            <i class="far fa-gift"></i>
                                        </label>
                                        <input id="offerVolunteer" type="radio" name="offer_kind" value="3" />
                                        <label class="bg-white shadow-1 rounded p-2"for="offerVolunteer">
                                            <i class="far fa-hands-helping"></i>
                                        </label>
                                        <input id="offerOther" type="radio" name="offer_kind" value="4" />
                                        <label class="bg-white shadow-1 rounded p-2"for="offerOther">
                                            <i class="far fa-hands-heart"></i>
                                        </label>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    --}}
            
            {{-- Financial contribution --}}
                <div class="row d-none donation-choice donation-choice-1">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('views.donation_kind_financial')</h5>
                    </div>
                    
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <span class="dark-gray">@lang('views.financial_contribution_description')</span>
                                <br />
                                <a href="/post/donate" target="_blank">@lang('menu.donate') ></a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            
            
            {{-- Gifting --}}
                <div class="row d-none donation-choice donation-choice-2">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('views.gifting')</h5>
                        <span class="dark-gray">@lang('views.reward')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <strong>@lang('views.reward'):</strong>
                                    <select name="group" class="selectpicker" title="@lang('views.choose')">
                                        <option value="1">@lang('views.gift_kind_free_festival')</option>
                                        <option value="2">@lang('views.gift_kind_free_other')</option>
                                        <option value="3">@lang('views.gift_kind_fee')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('views.gift_details'),
                                      'name' => 'gift_description',
                                      'placeholder' => '',
                                      'value' => old('gift_description')
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            {{-- Volunteering --}}
                <div class="row d-none donation-choice donation-choice-3">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('views.volunteering')</h5>
                        <p class="dark-gray">@lang('views.volunteering_thank_you')</p>
                        <p class="dark-gray">@lang('views.volunteering_details')</p>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <strong>@lang('views.volunteering_looking_for'):</strong>
                                    <select name="group" class="selectpicker" title="@lang('views.choose')">
                                        <option value="1">@lang('views.volunteering_kind_developers')</option>
                                        <option value="2">@lang('views.volunteering_kind_fundrisers')</option>
                                        <option value="3">@lang('views.volunteering_kind_translators')</option>
                                        <option value="4">@lang('views.volunteering_kind_communicators')</option>
                                        <option value="5">@lang('views.volunteering_kind_other')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('views.volunteering_details_request'),
                                      'name' => 'volunteer_description',
                                      'placeholder' => '',
                                      'value' => old('volunteer_description')
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            {{-- Other --}}
                <div class="row d-none donation-choice donation-choice-4">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('views.other')</h5>
                        <span class="dark-gray">@lang('views.other_description')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('views.other'),
                                      'name' => 'volunteer_description',
                                      'placeholder' => '',
                                      'value' => old('volunteer_description')
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            {{-- Thank you --}}
                {{--<div class="row">
                    <div class="col form-sidebar">
                        
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <h4>@lang('views.thank_you')</h4>
                                <p class="dark-gray">
                                    @lang('views.thank_you_desc')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>--}}
                
            <hr class="mt-3 mb-5">

            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('partials.forms.buttons-back-submit', [
                        'route' => 'donationOffers.index'  
                    ])
                </div>
            </div>

        </form>
    </div>
@endsection
