@section('javascript-document-ready')
    @parent

    {{-- Update the multiple teachers hidden input when a teacher is selected in the bootstrap select --}}
    $('#teacher').change(function(){
        $('#multiple_teachers').val($('#teacher').val());
     });

     {{-- Select the teachers that are already selected --}}
     var teachersSelected = $('#multiple_teachers').val();
     if (teachersSelected){
         var teachersSelectedArray = teachersSelected.split(',');
         $('#teacher').selectpicker('val', teachersSelectedArray);
     }

@stop


<div class="form-group" >
    <select id="teacher" class="selectpicker" title="Select teacher">
        @foreach ($teachers as $value => $teacher)
            <option value="{{$value}}">{!! $teacher !!}</option>
        @endforeach
    </select>
</div>
