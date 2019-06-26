
@section('javascript-document-ready')
    @parent

    {{-- Prevent click on the first level element of right menu --}}

@stop


{{--  Authentication Links --}}
@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-user-plus"></i> @lang('laravel-quick-menus::menu.create_account')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in "></i> @lang('laravel-quick-menus::menu.login')</a>
    </li>


@else
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="fas fa-user-circle"></i>  {{--{{ Auth::user()->name }}--}}  <span class="caret"></span>
        </a>

      <ul class="dropdown-menu sm-nowrap dropdown-menu-right">

        {{-- <a class="dropdown-item" href="{{ route('users.index') }}">{{ __('laravel-quick-menus::Users') }}</a> --}}
        {{-- User profile --}}
        <li>
            <a class="dropdown-item" href="{{ route('users.edit', ['id' => Auth::user()->id]) }}"> <i class="far fa-user-cog"></i> {{ __('laravel-quick-menus::menu.my_profile') }}</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out "></i> @lang('laravel-quick-menus::menu.logout')
            </a>
         </li>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      </ul>
  </li>
@endguest
