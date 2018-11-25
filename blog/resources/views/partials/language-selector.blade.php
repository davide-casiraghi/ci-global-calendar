

<div class="dropdown show">
  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img src="/images/flags/{{ Config::get('app.locale') }}.gif" alt="">
    {{--Change language--}}
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            {{ $localeCode }} - {{ $properties['native'] }}
        </a>
    @endforeach
  </div>
</div>
