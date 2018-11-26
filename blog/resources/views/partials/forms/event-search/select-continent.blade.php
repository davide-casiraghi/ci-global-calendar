<select name="continent_id" id="continent" class="selectpicker" data-live-search="true" title="@lang('homepage-serach.select_a_continent')">
    @foreach ($continents as $value => $continent)
        <option value="{{$value}}" {{ $searchContinent == $value ? 'selected' : '' }} >{!! $continent !!} </option>
    @endforeach
</select>
