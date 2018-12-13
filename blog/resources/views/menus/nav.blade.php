
{{-- Nav bar - Bootrap 4  and https://www.smartmenus.org--}}

<nav class="navbar navbar-expand-lg navbar-light"> {{--navbar-dark bg-dark--}}
    <div class="container">
        {{--<a class="navbar-brand" href="#">Navbar</a>--}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
  </div>
</nav>
