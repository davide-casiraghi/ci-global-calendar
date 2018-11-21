@section('javascript')
    @parent
    javascript-category

@stop

<div class="form-group">
    <strong>Category:</strong>
    <select name="category_id" class="selectpicker" title="Select category">
        @foreach ($eventCategories as $value => $eventCategory)
            <option value="{{$value}}" @if(!empty($event->category_id)) {{  $event->category_id == $value ? 'selected' : '' }}@endif>{!! $eventCategory !!}</option>
        @endforeach
    </select>
</div>
