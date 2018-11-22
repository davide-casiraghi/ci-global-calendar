<div class="form-group">
    <strong>Country:</strong>
    <select name="country_id" class="selectpicker" title="Select country"  data-live-search="true">
        @foreach ($countries as $key => $country)
            <option value="{{$key}}" @if(!empty($value)) {{ $value == $key ? 'selected' : '' }} @endif>{{ $country }} </option>
        @endforeach
    </select>
</div>
