<select name="country_id" id="country" class="selectpicker" data-live-search="true" title="Search by country">
    @foreach ($countries as $value => $country)
        <option value="{{$value}}" {{ $searchCountry == $value ? 'selected' : '' }} >{!! $country !!} </option>
    @endforeach
</select>
