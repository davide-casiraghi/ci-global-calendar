
{{--  Authentication Links --}}
@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
    </li>--}}

@else
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

         <a class="dropdown-item" href="{{ route('posts.index') }}">{{ __('Posts') }}</a>
         <a class="dropdown-item" href="{{ route('categories.index') }}">{{ __('Categories') }}</a>
         <a class="dropdown-item" href="{{ route('events.index') }}">{{ __('Events') }}</a>
         <a class="dropdown-item" href="{{ route('eventCategories.index') }}">{{ __('Event Categories') }}</a>
         <a class="dropdown-item" href="{{ route('eventVenues.index') }}">{{ __('Venues') }}</a>
         <a class="dropdown-item" href="{{ route('teachers.index') }}">{{ __('Teachers') }}</a>
         <a class="dropdown-item" href="{{ route('organizers.index') }}">{{ __('Organizers') }}</a>

         <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
             {{ __('Logout') }}
         </a>



          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      </div>
  </li>
@endguest
