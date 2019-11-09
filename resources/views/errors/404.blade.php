@extends('layouts.app') 
{{--@extends('layouts.hpEventSearch')--}}

<?php use App\BackgroundImage;?>

@section('javascript-document-ready')
    @parent

    {{--  Smooth Scroll on search - when we have anchor on the url --}}
        if ( window.location.hash ) scroll(0,0); {{-- to top right away --}}
        setTimeout( function() { scroll(0,0); }, 1); {{-- void some browsers issue --}}

        if(window.location.hash) {
            {{-- smooth scroll to the anchor id --}}
            $('html, body').animate({
                scrollTop: $(window.location.hash).offset().top + 'px'
            }, 1300, 'swing');
            
        }
    
    {{-- Update Continent SELECT on change Country SELECT --}}
        $("select[name='country_id']").on('change', function() {
            //alert( this.value );

            var request = $.ajax({
                url: "/update_continents_dropdown",
                data: {
                    country_id: this.value,
                },
                success: function( data ) {
                    $("#continent_id").selectpicker('val', data);
                }
            });
        });

    {{-- Update Country SELECT on change Continent SELECT --}}
        $("select[name='continent_id']").on('change', function() {
            updateCountriesDropdown(this.value);
        });
        
        
        
        $(document).ready(function(){
            
            {{-- On page load update the Country SELECT if a Continent is selected --}}
                var continent_id =  $("select[name='continent_id']").val();
                var country_id =  $("select[name='country_id']").val();
                 
                if (continent_id != ''){
                    
                    //alert(continent_id);
                    updateCountriesDropdown(continent_id);
                    if (country_id != null){
                        setTimeout(() => {
                            $("#country_id").selectpicker('val', country_id);
                        }, 300);
                     }
                 }
		});
        
        {{-- Update the Countries SELECT with just the ones 
             relative to the selected continent --}}
        function updateCountriesDropdown(selectedContinent){
            var request = $.ajax({
                url: "/update_countries_dropdown",
                data: {
                    continent_id: selectedContinent,
                },
                success: function( data ) {
                    $("#country_id").html(data);
                    $("#country_id").selectpicker('refresh');
                }
            });
        }

@stop

@section('beforeContent')

    {{-- This is to show the user activation message in homepage to the Admin, when click on the user activation link --}}
        @if(session()->has('message'))
            <div class="alert alert-success" style="z-index:3;">
                {{ session()->get('message') }}
            </div>
        @endif
        
        

    {{-- HI-Light for the donations --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('partials.hilight', [
                    'title' =>  'Dear users: ',
                    'text' =>  'The CI Global Calendar is a non-profit project to support the CI Global Community. 
                                To protect our independence we don’t want to run ads. We have no governmental funds. 
                                If the calendar is useful to you take one minute to help us keep it online another year. If everyone reading this message would give the same amount that you offer for a jam, our fundraiser would be done within a week. Thank you!',
                      'linkText' => 'Donate',
                      'linkUrl'  => '/post/donate',
                ])
            </div>
        </div>
    </div>
    
    


    {{-- The event search interface in Homepage --}}
    <div class="eventSearch jumbotron">
        <?php $backgroundImages = BackgroundImage::all();?>
        @include('partials.jumboBackgroundChange',['backgroundImages' => $backgroundImages] )
		
		
        
        
        <div class="container">
			<div class="row-intro">
				<div class="col-12 text-center">
					<br>
					<p class="subtitle text-black">
					<h1 class="text-white mb-3">The page you request has not been found, please report this issue to the <a href="/en/contactForm/compose/project-manager">administrator</a>.</h1>
					</p>
				</div>
			</div>
		</div>   
        
        <div class="bg-overlay"></div>


    </div>

@endsection

{{--
@section('content')

@endsection
--}}
