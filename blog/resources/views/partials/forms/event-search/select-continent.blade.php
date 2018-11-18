<select name="continent_id" id="continent" class="selectpicker" data-live-search="true" title="Select a continent">
    @foreach ($continents as $value => $continent)
        <option value="{{$value}}" {{ $searchContinent == $value ? 'selected' : '' }} >{!! $continent !!} </option>
    @endforeach
</select>
