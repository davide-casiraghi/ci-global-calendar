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
                <h4>@lang('donations.create_new_donation_offer')</h4>
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
                                    'title' =>  __('donations.contact_through_skype_or_another_voip'),
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
                                    'title' =>  __('donations.language_spoken'),
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
                
                {{-- How you want to help - OFFER KIND --}}
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
                                @include('partials.forms.select', [
                                      'title' => __('donations.reward'),
                                      'name' => 'gift_kind',
                                      'placeholder' => __('views.choose'), 
                                      'records' => App\DonationOffer::getGiftKindArray(),
                                      'liveSearch' => 'false',
                                      'mobileNativeMenu' => true,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('donations.gift_details'),
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
                        <h5 class="text-xl">@lang('donations.volunteering')</h5>
                        <p class="dark-gray">@lang('donations.volunteering_thank_you')</p>
                        <p class="dark-gray">@lang('donations.volunteering_details')</p>
                    </div>
                    <div class="col main">
                        <div class="row">
                            <div class="col-12">
                                <strong>@lang('donations.volunteering_looking_for')</strong>
                                <ul class="customList customList-handList mt-2">
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
                                      'liveSearch' => 'false',
                                      'mobileNativeMenu' => true,
                                ])
                            </div>
                            <div class="col-12">
                                @include('partials.forms.textarea', [
                                      'title' =>  __('donations.volunteering_details_request'),
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
                                      'value' => old('other_description')
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
