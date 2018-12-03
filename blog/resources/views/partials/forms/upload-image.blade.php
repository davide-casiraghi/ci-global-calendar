@section('javascript-document-ready')
    @parent
    $('.custom-file-input').on('change',function(){
        {{-- get the file name --}}
            var filePath = $(this).val();
            var fileName = filePath.replace(/^.*[\\\/]/, '')
        {{-- replace the "Choose a file" label --}}
            $(this).next('.custom-file-label').html(fileName);
    })
@stop


@if(!empty($title))<label for="{{ $name }}">{{ $title }}:</label>@endif
<div class="form-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="inputGroupFile04">
        <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
    </div>
    {{--<div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button">Button</button>
    </div>--}}
</div>
