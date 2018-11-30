@section('javascript-document-ready')
    @parent

    {{-- Update the multiple organizers hidden input when a teacher is selected in the bootstrap select --}}
    $('#organizer').change(function(){
        $('#multiple_organizers').val($('#organizer').val());
     });

     {{-- Select the organizers that are already selected --}}
     var organizersSelected = $('#multiple_organizers').val();
     if (organizersSelected){
         var organizersSelectedArray = organizersSelected.split(',');
         $('#organizer').selectpicker('val', organizersSelectedArray);
     }
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
