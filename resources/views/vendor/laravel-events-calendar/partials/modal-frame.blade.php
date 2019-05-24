{{--
    Modal - Bootstrap 4 - https://getbootstrap.com/docs/4.0/components/modal/

    used in event create and edit view.
    it get populated on a click on the button like:
    <button type="button" data-toggle="modal" class="btn btn-primary mb-3 mb-sm-0 mt-sm-4" data-remote="{{ route('teachers.modal') }}" data-target=".modalFrame">
        <i class="fa fas fa-plus-circle "></i> @lang('laravel-events-calendar::teacher.create_new_teacher')
    </button>


    PARAMETERS:
        none
--}}

@section('javascript-document-ready')
    @parent
    {{-- Load the Bootstrap 4 modal to create a new teacher or organizer or eventVenue --}}
    $('.modalFrame').on('show.bs.modal', function (e) {
        $(this).find('.modal-content').load($(e.relatedTarget).attr('data-remote'));
    });

 @stop

<div class="modal fade modalFrame" tabindex="-1"
    role="dialog" aria-labelledby="modalFrameLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content light-gray-bg">
            
            {{--
                Here is injected the code from 
                    - views/partials/organizers/modal
                    - views/partials/teachers/modal
                    - views/partials/eventVenues/modal    
            --}}
            
            
            {{--<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="myModalLabel">Model Title</h3>
            </div>
            <div class="modal-body">
                <p>
                    <img alt="loading" src="/storage/images/ajax-loader.gif">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>--}}
        </div>
    </div>
</div>
