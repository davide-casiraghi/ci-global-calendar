@extends('donationOffers.layout')


@section('content')
    <div class="container max-w-lg px-0">
        <div class="row pt-4">
            <div class="col-12">
                <h4>@lang('donations.edit_donation_offer')</h4>
            </div>
        </div>
        
        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])
        
        <hr class="mt-3 mb-4">
        
        <form action="{{ route('donationOffers.update',$donationOffer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Basics --}}
                <div class="row">
                    <div class="col-12 col-md form-sidebar">
                        <h5 class="text-xl">@lang('donations.your_contact_details')</h5>
                        <span class="dark-gray">@lang('donations.your_contact_details_desc')</span>
                    </div>
                    <div class="col-12 col-md main">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.name'),
                                      'name' => 'name',
                                      'placeholder' => '',
                                      'value' => $donationOffer->name
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.surname'),
                                      'name' => 'surname',
                                      'placeholder' => '',
                                      'value' => $donationOffer->surname
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.email_address'),
                                      'name' => 'email',
                                      'value' => $donationOffer->email
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea-plain', [
                                    'title' =>  __('donations.contact_through_skype_or_another_voip'),
                                    'name' => 'contact_trough_voip',
                                    'value' => $donationOffer->contact_trough_voip
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.select', [
                                      'title' => __('general.country'),
                                      'name' => 'country_id',
                                      'placeholder' => __('views.select_country'), 
                                      'records' => $countries,
                                      'seleted' => $donationOffer->country_id,
                                      'liveSearch' => 'true',
                                      'mobileNativeMenu' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea-plain', [
                                    'title' =>  __('donations.language_spoken'),
                                    'name' => 'language_spoken',
                                    'value' => $donationOffer->language_spoken
                                ])
                            </div>
                            
                            
                            
                            {{-- Show the created by field just to the admin and super admin --}}
                            {{--@if(empty($authorUserId))
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
                            --}}
                            
                        </div>
                    </div>
                </div>
            
                <hr class="mt-3 mb-4">
                
                {{-- How you want to help --}}
                    <div class="row">
                        <div class="col form-sidebar">
                            <h5 class="text-xl">@lang('donations.i_want_to_help')</h5>
                            <span class="dark-gray">@lang('donations.kind_of_help_description')</span>
                        </div>
                        <div class="col main">
                            <div class="row">
                                <div class="col-12">
                                    @include('partials.forms.input-radio-cards', [
                                        'title' =>  __('donations.i_can_offer'),
                                        'name' => 'offer_kind',
                                        'selected' => $donationOffer->offer_kind
                                    ])
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
                        <h5 class="text-xl">@lang('donations.donation_kind_financial')</h5>
                    </div>
                    
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <span class="dark-gray">@lang('donations.financial_contribution_description')</span>
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
                        <h5 class="text-xl">@lang('donations.gifting')</h5>
                        <span class="dark-gray">@lang('donations.reward')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <strong>@lang('donations.reward'):</strong>
                                    <select name="gift_kind" class="selectpicker" title="@lang('views.choose')">
                                        <option value="1">@lang('donations.gift_kind_free_festival')</option>
                                        <option value="2">@lang('donations.gift_kind_free_other')</option>
                                        <option value="3">@lang('donations.gift_kind_fee')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('donations.gift_details'),
                                      'name' => 'gift_description',
                                      'placeholder' => '',
                                      'value' => $donationOffer->gift_description
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            {{-- Volunteering --}}
                <div class="row d-none donation-choice donation-choice-3">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('donations.volunteering')</h5>
                        <p class="dark-gray">@lang('donations.volunteering_thank_you')</p>
                        <p class="dark-gray">@lang('donations.volunteering_details')</p>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <strong>@lang('donations.volunteering_looking_for'):</strong>
                                    <select name="group" class="selectpicker" title="@lang('views.choose')">
                                        <option value="1">@lang('donations.volunteering_kind_developers')</option>
                                        <option value="2">@lang('donations.volunteering_kind_fundrisers')</option>
                                        <option value="3">@lang('donations.volunteering_kind_translators')</option>
                                        <option value="4">@lang('donations.volunteering_kind_communicators')</option>
                                        <option value="5">@lang('donations.volunteering_kind_other')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('donations.volunteering_details_request'),
                                      'name' => 'volunteer_description',
                                      'placeholder' => '',
                                      'value' => $donationOffer->volunteer_description
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            {{-- Other --}}
                <div class="row d-none donation-choice donation-choice-4">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('donations.other')</h5>
                        <span class="dark-gray">@lang('donations.other_description')</span>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('donations.other'),
                                      'name' => 'other_description',
                                      'placeholder' => '',
                                      'value' => $donationOffer->other_description
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
            
            @include('partials.forms.input-hidden', [
                  'name' => 'status',
                  'value' => 1
            ])

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
