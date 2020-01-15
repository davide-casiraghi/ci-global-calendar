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
    <div class="col-12">
        <div class="form-group" >
            <label>@lang('laravel-events-calendar::general.organizers')</label>
            <select id="organizer" name="selected_organizers" class="selectpicker multiselect" multiple data-live-search="true" title="@lang('laravel-events-calendar::general.choose')">
                @foreach ($organizers as $value => $organizer)
                    <option value="{{$value}}">{!! $organizer !!}</option>
                @endforeach
            </select>
            <input type="hidden" name="multiple_organizers" id="multiple_organizers" value="{{$multiple_organizers}}" />
        </div>
    </div>
    <div class="col-12 mb-1">
        <button type="button" data-toggle="modal" class="btn btn-primary float-right" data-remote="{{ route('organizers.modal') }}" data-target=".modalFrame"><i class="fa fas fa-plus-circle "></i> @lang('laravel-events-calendar::organizer.create_new_organizer')</button>
    </div>
</div>
