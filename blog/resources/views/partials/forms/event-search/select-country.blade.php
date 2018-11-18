<select name="country_id" id="country" class="selectpicker mt-3" data-live-search="true" title="Select a country">
    @foreach ($countries as $value => $country)
        <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
    @endforeach
</select>
