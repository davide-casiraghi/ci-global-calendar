@section('javascript-document-ready')
    @parent
    $('#organizer').change(function(){
        $('#multiple_organizers').val($('#organizer').val());
     });
@stop


<div class="form-group" >
    <strong>Organizers:</strong>
    <select id="organizer" class="selectpicker multiselect" multiple title="Select organizer">
        @foreach ($organizers as $value => $organizer)
            <option value="{{$value}}">{!! $organizer !!}</option>
        @endforeach
    </select>
    <input type="hidden" name="multiple_organizers" id="multiple_organizers" @if(!empty($multiple_organizers)) value="{{$multiple_organizers}}" @endif/>
</div>
