@extends('layouts.app') 
{{--@extends('layouts.hpEventSearch')--}}

<?php use App\BackgroundImage;?>

@section('content')
        
    {{-- The event search interface in Homepage --}}
    <div class="eventSearch jumbotron">
        <?php $backgroundImages = BackgroundImage::all();?>
        @include('partials.jumboBackgroundChange',['backgroundImages' => $backgroundImages] )
		
        <div class="container max-w-md">
			<div class="row">
				<div class="col-12 text-center">
					<br>
					<h1 class="text-white mt-3 text-2xl">The page you request has not been found, please report this issue to the <a href="/en/contactForm/compose/administrator">administrator</a>.</h1>
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
