
<div class="row h-100">
    <div class="col-9 col-sm-9 col-md-9 pull-left my-auto">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><label for="{{ $db_column_name }}">{{ $title }}</label></span>
            </div>
            <input id="thumbnail" class="form-control mr-2" type="text" name="{{ $db_column_name }}" @if(!empty($image)) value="{{ $image }}" @endif>
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
        </div>
    </div>
    <div class="col-3 col-sm-3 col-md-3 pull-right my-auto">
        <img id="holder" @if(!empty($image)) src="{{ $image }}" @endif style="width:100%;">
    </div>
</div>
