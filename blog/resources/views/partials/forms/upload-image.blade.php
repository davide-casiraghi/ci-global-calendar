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

<div class="@if(!empty($value)) col-12 col-sm-8 col-md-8 @else col-12 col-sm-12 col-md-12 @endif ">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}:</label>@endif
    <div class="form-group">
        <div class="custom-file">
            <input type="file" name="{{ $name }}" class="custom-file-input">
            <label class="custom-file-label" for="{{ $name }}">Choose file</label>
        </div>
    </div>
</div>
{{$value}}
{{-- Show the Image that has been already stored --}}
@if(!empty($value))
    <div class="col-12 col-sm-4 col-md-4">
        <img style="width: 100%" src="images/teachers_profile/{{$value}}" alt="">
    </div>
@endif
