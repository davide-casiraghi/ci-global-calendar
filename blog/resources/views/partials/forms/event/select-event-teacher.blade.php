@section('javascript-document-ready')
    @parent

    {{-- Update the multiple teachers hidden input when a teacher is selected in the bootstrap select --}}
    $('#teacher').change(function(){
        $('#multiple_teachers').val($('#teacher').val());
     });

     {{-- Select the teachers saved when the edit view is open  --}}
     var teachersSelected = $('#multiple_teachers').val();
     if (teachersSelected){
         var teachersSelectedArray = teachersSelected.split(',');
         $('#teacher').selectpicker('val', teachersSelectedArray);
     }

@stop

<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="form-group" >
            <strong>@lang('general.teachers'):</strong>
            <select id="teacher" class="selectpicker multiselect" multiple data-live-search="true" title="@lang('homepage-serach.teacher_name')">
                @foreach ($teachers as $value => $teacher)
                    <option value="{{$value}}">{!! $teacher !!}</option>
                @endforeach
            </select>
            <input type="hidden" name="multiple_teachers" id="multiple_teachers" @if(!empty($multiple_teachers))  value="{{$multiple_teachers}}" @endif/>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6">
        <button type="button" data-toggle="modal" class="btn btn-primary mb-3 mb-sm-0 mt-sm-4" data-remote="{{ route('teachers.modal') }}" data-target=".modalFrame">@lang('views.create_new_teacher')</button>
    </div>
</div>

@include('partials.forms.modal-frame')
