<select name="category_id" id="category" class="selectpicker" data-live-search="true" title="All kind of events">
    @foreach ($eventCategories as $value => $eventCategory)
        <option value="{{$value}}" {{ $searchCategory == $value ? 'selected' : '' }} >{!! $eventCategory !!} </option>
    @endforeach
</select>
