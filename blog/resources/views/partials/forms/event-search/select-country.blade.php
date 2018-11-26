<select name="country_id" id="country" class="selectpicker mt-3" data-live-search="true" title="@lang('homepage-serach.select_a_country')">
    @foreach ($countries as $value => $country)
        <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
    @endforeach
</select>
