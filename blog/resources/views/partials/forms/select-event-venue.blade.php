@section('javascript')
    @parent
    javascript-venues

@stop
<div class="form-group" >
    <strong>Venues:</strong>
    <select name="venue_id" class="selectpicker" title="Select venue" data-live-search="true">
        @foreach ($venues as $value => $venue)
            <option value="{{$venue->id}}" @if(!empty($event->venue_id)) {{ $event->venue_id == $venue->id ? 'selected' : '' }} @endif>{!! $venue->name !!} - {!! $venue->city !!}</option>
        @endforeach
    </select>
</div>
