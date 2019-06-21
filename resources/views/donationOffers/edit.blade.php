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
                            
                            @if( App\User::loggedAsSuperAdmin() || App\User::loggedAsAdmin() )
                                <div class="col-12">
                                    @include('partials.forms.select', [
                                          'title' => __('views.status'),
                                          'name' => 'status',
                                          'placeholder' => __('views.choose'), 
                                          'records' => App\DonationOffer::getStatusArray(),
                                          'seleted' => $donationOffer->status,
                                          'liveSearch' => 'false',
                                          'mobileNativeMenu' => true,
                                          'required' => false,
                                    ])
                                </div>
                            @endif
                            
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.name'),
                                      'name' => 'name',
                                      'placeholder' => '',
                                      'value' => $donationOffer->name,
                                      'required' => true,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.surname'),
                                      'name' => 'surname',
                                      'placeholder' => '',
                                      'value' => $donationOffer->surname,
                                      'required' => true,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('general.email_address'),
                                      'name' => 'email',
                                      'value' => $donationOffer->email,
                                      'required' => true,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea-plain', [
                                    'title' =>  __('donations.contact_through_skype_or_another_voip'),
                                    'name' => 'contact_trough_voip',
                                    'value' => $donationOffer->contact_trough_voip,
                                    'required' => false,
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
                                      'required' => false,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea-plain', [
                                    'title' =>  __('donations.language_spoken'),
                                    'name' => 'language_spoken',
                                    'value' => $donationOffer->language_spoken,
                                    'required' => true,
                                ])
                            </div>
                            
                        </div>
                    </div>
                </div>
            
                <hr class="mt-3 mb-4">
                
                {{-- How you want to help - OFFER KIND --}}
                    @include('partials.forms.input-hidden', [
                          'name' => 'offer_kind',
                          'value' => $donationOffer->offer_kind,
                    ])
                    
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
                                        'records' =>  App\DonationOffer::getDonationKindArray(),
                                        'selected' => $donationOffer->offer_kind,
                                        'required' => true,
                                    ])
                                </div>
                                                                    
                            </div>
                        </div>
                    </div>
            
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
                
            {{-- Volunteering --}}
                <div class="row d-none donation-choice donation-choice-2">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <h5 class="text-xl">@lang('donations.volunteering')</h5>
                        <p class="dark-gray">@lang('donations.volunteering_thank_you')</p>
                        <p class="dark-gray">@lang('donations.volunteering_details')</p>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <strong>@lang('donations.volunteering_looking_for')</strong>
                                <ul class="customList customList-handList checkList mt-2">
                                    @foreach (App\DonationOffer::getVolunteeringKindDescriptionsArray() as $key => $value)
                                        <li>{{$value}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="col-12">
                                @include('partials.forms.select', [
                                      'title' => __('donations.volunteering_apply_for'),
                                      'name' => 'volunteer_kind',
                                      'placeholder' => __('views.choose'), 
                                      'records' => App\DonationOffer::getVolunteeringKindArray(),
                                      'seleted' => $donationOffer->volunteer_kind,
                                      'liveSearch' => 'false',
                                      'mobileNativeMenu' => true,
                                      'required' => true,
                                ])
                            </div>
                            
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('donations.volunteering_details_request'),
                                      'name' => 'volunteer_description',
                                      'placeholder' => '',
                                      'value' => $donationOffer->volunteer_description,
                                      'required' => true,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            
            {{-- Free Entrance / Other Gift --}}
                <div class="row d-none donation-choice donation-choice-3">
                    <div class="col-12"><hr class="mt-3 mb-4"></div>
                    <div class="col form-sidebar">
                        <div class="other-gift-bar-visibility">
                            <h5 class="text-xl">@lang('donations.other_gift')</h5>
                            <p class="dark-gray">@lang('donations.other_description')</p>
                            <p class="dark-gray">@lang('donations.other_suggestion')</p>
                        </div>
                        <div class="entrance-bar-visibility">
                            <h5 class="text-xl">@lang('donations.donation_kind_free_entrance')</h5>
                            <span class="dark-gray">@lang('donations.gift_kind_free_festival')</span>
                        </div>
                    </div>
                    <div class="col main">
                        <div class="row">
                            
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('donations.gift_title'),
                                      'name' => 'gift_title',
                                      'placeholder' => '',
                                      'value' => $donationOffer->gift_title,
                                      'required' => true,
                                ])
                            </div>
                            
                            <div class="col-12 entrance-kind-visibility">
                            @include('partials.forms.select', [
                                      'title' => __('donations.entrance_kind'),
                                      'name' => 'gift_kind',
                                      'placeholder' => __('views.choose'), 
                                      'records' => App\DonationOffer::getGiftKindArray(),
                                      'seleted' => $donationOffer->gift_kind,
                                      'liveSearch' => 'false',
                                      'mobileNativeMenu' => true,
                                      'required' => true,
                                ])
                            </div>
                            
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('donations.gift_donater'),
                                      'name' => 'gift_donater',
                                      'placeholder' => '',
                                      'value' => $donationOffer->gift_donater,
                                      'required' => true,
                                ])
                            </div>
                            
                            <div class="col-12">
                               @include('partials.forms.textarea', [
                                     'title' =>  __('donations.gift_details'),
                                     'name' => 'gift_description',
                                     'placeholder' => '',
                                     'value' => $donationOffer->gift_description,
                                     'required' => true,
                               ])
                           </div>
                            
                            <div class="col-12">
                                @include('partials.forms.input', [
                                      'title' => __('donations.gift_economic_value'),
                                      'name' => 'gift_economic_value',
                                      'placeholder' => '',
                                      'value' => $donationOffer->gift_economic_value,
                                      'required' => true,
                                ])
                            </div>
                            
                            <div class="col-12">
                                @include('partials.forms.select', [
                                      'title' => __('donations.gift_country_of'),
                                      'name' => 'gift_country_of',
                                      'placeholder' => __('views.select_country'), 
                                      'records' => $countries,
                                      'liveSearch' => 'true',
                                      'mobileNativeMenu' => false,
                                      'seleted' => $donationOffer->gift_country_of,
                                      'required' => false,
                                ])
                            </div>
                            
                            @if( App\User::loggedAsSuperAdmin() || App\User::loggedAsAdmin() )
                                <div class="col-12">
                                    @include('partials.forms.input', [
                                          'title' => __('donations.gift_volunteer_time_value'),
                                          'name' => 'gift_volunteer_time_value',
                                          'placeholder' => '',
                                          'value' => $donationOffer->gift_volunteer_time_value,
                                          'required' => true,
                                    ])
                                </div>
                                <div class="col-12">
                                    @include('partials.forms.input', [
                                          'title' => __('donations.gift_given_to'),
                                          'name' => 'gift_given_to',
                                          'placeholder' => '',
                                          'value' => $donationOffer->gift_given_to,
                                          'required' => true,
                                    ])
                                </div>
                                <div class="col-12">    
                                    @include('partials.forms.input-date', [
                                          'title' =>  __('donations.gift_given_when'),
                                          'name' => 'gift_given_when',
                                          'placeholder' => __('views.select_date'),
                                          'endDate' => '+1y',
                                          'value' => $donationOffer->gift_given_when,
                                          'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                                          'tooltipText' => __('views.max_until'),
                                          'required' => true,
                                    ])
                                </div>
                            @endif
                            
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
