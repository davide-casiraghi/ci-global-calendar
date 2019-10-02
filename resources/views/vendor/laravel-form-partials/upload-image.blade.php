
{{--
    UPLOAD IMAGE

    IMPORTANT: when use this add to the form enctype="multipart/form-data"
                like: <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $folder: string - the folder name where to store the images in /storage/app/public/images/..
        - $value: the already stored value (used in edit view to retrieve the already stored value, in create view can be '')
--}}

@section('javascript-document-ready')
    @parent
    {{-- When an image is chosen, replace the "Choose a file" label --}}
    $('.custom-file-input').on('change',function(){
        {{-- get the file name --}}
            var filePath = $(this).val();
            var fileName = filePath.replace(/^.*[\\\/]/, '')
        {{-- replace the "Choose a file" label --}}
            $(this).next('.custom-file-label').html(fileName);
    })
    
    {{-- Delete an already uploaded image --}}
    $('.deleteImage').on('click',function(){
        $("input[name='{{$name}}']").val("");
        $("img.uploadedImage").remove();
    })
    
@stop

<div class="@if(!empty($value)) col-12 col-sm-8 col-md-8 @else col-12 col-sm-12 col-md-12 @endif ">
    @if(!empty($title))<label for="{{ $name }}">{{ $title }}</label>@endif
    <div class="form-group">
        <div class="custom-file">
            <input type="file" name="{{ $name }}" @if(!empty($value)) value="{{ $value }}" @endif class="custom-file-input">
            <label class="custom-file-label" for="{{ $name }}">
                @if(!empty($value))
                    @lang('laravel-form-partials::general.click_to_upload_new_image')
                @else
                    @lang('laravel-form-partials::general.chose_file')
                @endif
            </label>
        </div>
    </div>
    @if(!empty($value))
        <button type="button" class="btn btn-danger deleteImage"><i class="far fa-trash-alt"></i> Delete image</button>
    @endif
</div>
{{-- Show the Image that has been already stored --}} 
@if(!empty($value))
    <div class="col-12 col-sm-4 col-md-4">
        <img class="uploadedImage" style="width: 100%" src="/storage/images/{{$folder}}/{{$value}}" alt="">
    </div>
    
    {{-- show the image name to use in the edit view to not delete the image on update --}}
    @include('laravel-form-partials::input-hidden', [
          'name' => $name,
          'value' => $value
    ])
    
@endif
