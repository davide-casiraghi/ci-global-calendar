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

<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="form-group" >
            <strong>@lang('views.organizers'):</strong>
            <select id="organizer" class="selectpicker multiselect" multiple data-live-search="true" title="@lang('homepage-serach.organizer_name')">
                @foreach ($organizers as $value => $organizer)
                    <option value="{{$value}}">{!! $organizer !!}</option>
                @endforeach
            </select>
            <input type="hidden" name="multiple_organizers" id="multiple_organizers" @if(!empty($multiple_organizers)) value="{{$multiple_organizers}}" @endif/>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6">
        <button type="button" data-toggle="modal" class="btn btn-primary mb-3 mb-sm-0 mt-sm-4" data-remote="{{ route('organizers.modal') }}" data-target=".modalFrame">@lang('views.add_new_organizer')</button>
    </div>
</div>
