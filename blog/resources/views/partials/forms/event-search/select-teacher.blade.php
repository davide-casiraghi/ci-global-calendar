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
    <select name="teacher_id" id="teacher" class="selectpicker" title="Select teacher" data-live-search="true">
        @foreach ($teachers as $value => $teacher)
            <option value="{{$value}}" {{ $searchTeacher == $value ? 'selected' : '' }}>{!! $teacher !!}</option>
        @endforeach
    </select>
</div>
