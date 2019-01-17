
@section('javascript-document-ready')
    @parent

    {{-- Prevent click on the first level element of right menu --}}

@stop


{{--  Authentication Links --}}
@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> @lang('menu.create_account')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in "></i> @lang('menu.login')</a>
    </li>


@else
    <li class="nav-item dropdown">
        <a id="navbarRightDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="far fa-user-circle"></i>  {{--{{ Auth::user()->name }}--}}  <span class="caret"></span>
        </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarRightDropdown">

        {{-- <a class="dropdown-item" href="{{ route('users.index') }}">{{ __('Users') }}</a> --}}
        {{-- User profile --}}
        <a class="dropdown-item" href="{{ route('users.edit', ['id' => Auth::user()->id]) }}"> <i class="far fa-user-cog"></i> {{ __('menu.my_profile') }}</a>
        
         <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
             <i class="fa fa-sign-out "></i> @lang('menu.logout')
         </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      </div>
  </li>
@endguest
