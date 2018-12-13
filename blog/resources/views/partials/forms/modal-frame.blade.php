
@section('javascript-document-ready')
    @parent
    {{-- Load the modal to create a new teacher --}}
    $('.modalFrame').on('show.bs.modal', function (e) {
        $(this).find('.modal-content').load($(e.relatedTarget).attr('data-remote'));
    });

 @stop

<div class="modal fade modalFrame" tabindex="-1"
    role="dialog" aria-labelledby="modalFrameLabel" aria-hidden="true">
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
                    <img alt="loading" src="/storage/images/ajax-loader.gif">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
