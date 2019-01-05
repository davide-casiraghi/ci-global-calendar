

<div class="dropdown show languages"> {{--btn-group dropleft--}}
  <a class="btn btn-link dropdown-toggle p-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img src="/images/flags/{{ Config::get('app.locale') }}.gif" alt="">
    {{--Change language--}}
  </a>

  <div class="dropdown-menu dropdown-menu-right">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{--{{ $localeCode }} - {{ $properties['native'] }} --}}
            <img class="mr-1" src="/images/flags/{{ $localeCode }}.gif" alt=""/>  {{ $properties['native'] }}
        </a>
    @endforeach
  </div>
</div>
