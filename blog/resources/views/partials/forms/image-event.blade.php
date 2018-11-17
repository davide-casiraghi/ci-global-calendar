<div class="row h-100 mt-3">
    <div class="col-xs-9 col-sm-9 col-md-9 pull-left my-auto">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><strong>Intro Image</strong></span>
            </div>
            <input id="thumbnail" class="form-control" type="text" name="image" @if(!empty($event->image)) value="{{ $event->image }}" @endif>
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 pull-right my-auto">
        <img id="holder" @if(!empty($event->image)) src="{{ $event->image }}" @endif style="width:100%;">
    </div>
</div>
