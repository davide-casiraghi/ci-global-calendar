
{{-- 
    Navbar - Bootrap 4  and https://www.smartmenus.org
    
    PARAMETERS:
        - $items: array - the items to show in the navbar
        - $container: boolean - show the menu in a container or not 
        - $padding-x: string - the padding on the left and right side of the nav bar, expressed in bootstrap spacing notation eg. px-5

--}}
    
@section('javascript')
    @parent
    
    
    
    {{-- When scroll down add class sticky-header to the menu top bar --}}
    	$(window).scroll(function(event){            
    	    fromTop = ($(window).scrollTop() );
    	    //console.log(fromTop);

    	    headerOffset = 0;

    	    if (fromTop > headerOffset) {
    	    	$('.navbar-default').addClass('transparent-bar');
    	    }
    	    else{
    	    	$('.navbar-default').removeClass('transparent-bar');
    	    }

    	});

@stop

@section('javascript-document-ready')
    @parent
    
    {{-- Add some margin abobe the contents to compensate the sticky menu --}}
    @if($stickyNavbar)
        $("#app").addClass('mt-5');
    @endif
    
    
    {{-- TOP MENU TRANSPARENT - Color on scrolling or show in pages that are not HP --}}
        @if (Route::is('home'))
            function transparentMenu() {
                var sticky_header = $('nav.navbar').outerHeight(true); // Get the height of element including padding, border, margin
                var sticky_menu = $('nav.navbar').outerHeight(true);  // Get the height of element including padding, border, margin
                if ($(window).scrollTop() >= sticky_header){
                    $('nav.navbar').addClass('nav_colored');
                    $('nav.navbar').removeClass('nav_trasp');
                } else {
                    $('nav.navbar').removeClass('nav_colored');
                    $('nav.navbar').addClass('nav_trasp');
                }
            }

        
        {{-- TOP MENU TRANSPARENT - Show and hide bars in homepage --}}
            //if ($('.navbar-default').hasClass('transparent-menu')){
                transparentMenu();
                $(window).scroll(function() {    
                    transparentMenu();
                });
            //}    
        @endif

    
@stop





<nav class="navbar navbar-expand-lg navbar-light @if($stickyNavbar) navbar-fixed-top @endif {{$paddingX}}" style="background-color: {{$backgroundColor}}"> {{--navbar-dark bg-dark--}}
    @if($container)<div class="container">@endif
        {{--<a class="navbar-brand" href="#">Navbar</a>--}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand d-block d-md-none">
            @include('partials.language-selector')
        </div>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">

      {{-- Left Nav --}}
      <ul class='navbar-nav mr-auto'>
          @include('menus.nav-items', ['items' => $MyNavBar->roots()])
      </ul>
      {{-- end - Left Nav --}}


      {{-- Right Nav --}}
      <ul class="navbar-nav navbar-right">
          @include('menus.nav-items', ['items' => $MyNavBarRight->roots()])
          @include('menus.nav-right-items')
      </ul>
      {{-- end - Right Nav --}}

    </div>
  @if($container)</div>@endif
</nav>
