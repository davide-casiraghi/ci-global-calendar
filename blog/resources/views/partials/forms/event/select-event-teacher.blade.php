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

    {{-- Load the modal to create a new teacher --}}
    $('#myModel').on('show.bs.modal', function (e) {
        $(this).find('.modal-content').load($(e.relatedTarget).attr('data-remote'));
    });

@stop

<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="form-group" >
            <strong>Teachers:</strong>
            <select id="teacher" class="selectpicker multiselect" multiple title="@lang('homepage-serach.teacher_name')">
                @foreach ($teachers as $value => $teacher)
                    <option value="{{$value}}">{!! $teacher !!}</option>
                @endforeach
            </select>
            <input type="hidden" name="multiple_teachers" id="multiple_teachers" @if(!empty($multiple_teachers))  value="{{$multiple_teachers}}" @endif/>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6">
        <button type="button" data-toggle="modal" class="btn btn-primary mb-3 mb-sm-0 mt-sm-4" data-remote="{{ route('teachers.modal') }}" data-target="#myModel">Add new teacher</button>
    </div>
</div>

<!-- Model -->
<div class="modal fade" id="myModel" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">Model Title</h3>
            </div>
            <div class="modal-body">
                <p>
                    <img alt="loading" src="resources/img/ajax-loader.gif">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
