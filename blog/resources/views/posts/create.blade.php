@extends('posts.layout')


@section('javascript')

    {{-- Initialize editor for the main textbox --}}
    <script type="text/javascript" src="{{ asset('js/tinymce/tinymce.min.js') }}" ></script>
    <script type="text/javascript">
		// https://www.tiny.cloud/docs/get-started/basic-setup/
			var editor_config = {
				selector: 'textarea#bodyTextarea',
				/*plugins : 'advlist autolink link image lists charmap print preview spellchecker media table',*/
				plugins: [
				 "advlist autolink lists link image charmap print preview hr anchor pagebreak",
				 "searchreplace wordcount visualblocks visualchars code fullscreen",
				 "insertdatetime media nonbreaking save table contextmenu directionality",
				 "emoticons template paste textcolor colorpicker textpattern"
			   ],
				theme: 'modern',
				height: 400,
				toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | blockquote | link image media  | hr',



				path_absolute : "/",
				relative_urls: false,
			    file_browser_callback : function(field_name, url, type, win) {
			      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
			      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

			      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
			      if (type == 'image') {
			        cmsURL = cmsURL + "&type=Images";
			      } else {
			        cmsURL = cmsURL + "&type=Files";
			      }

			      tinyMCE.activeEditor.windowManager.open({
			        file : cmsURL,
			        title : 'Filemanager',
			        width : x * 0.8,
			        height : y * 0.8,
			        resizable : "yes",
			        close_previous : "no"
			      });
			    }
			};

			tinymce.init(editor_config);
		</script>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New post</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => 'Title',
                      'name' => 'title',
                      'placeholder' => 'Event title',
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Slug:</strong>
                    <input type="text" name="slug" class="form-control" placeholder="Slug">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="selectpicker" data-live-search="true" title="Select category">
                        @foreach ($categories as $value => $category)
                            <option value="{{$value}}">{!! $category !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    <select name="status" class="form-control">
                        <option value="2" selected>Published</option>
                        <option value="1">Unpublished</option>
                    </select>

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Before Content:</strong>
                    <textarea class="form-control" style="height:150px" name="before_content" placeholder="Before the content"></textarea>
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-post', [
                      'title' => 'Text',
                      'name' => 'body',
                      'placeholder' => 'Post text',
                      'value' => ''
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>After Content:</strong>
                    <textarea class="form-control" style="height:150px" name="after_content" placeholder="After the content"></textarea>
                </div>
            </div>
        </div>

        <div class="row h-100 mt-3">
            <div class="col-6 pull-left my-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>Intro Image</strong></span>
                    </div>
                    <input id="thumbnail" class="form-control" type="text" name="introimage_src">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-3 pull-right my-auto">
                <input type="text" name="introimage_alt" class="form-control" placeholder="Alt">
            </div>
            <div class="col-3 pull-right my-auto">
                <img id="holder" style="width:100%;">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


        <input type="hidden" name="author_id" value="1">
        <!--<input type="hidden" name="category_id" value="3">-->
        <input type="hidden" name="meta_description" value="3">
        <input type="hidden" name="meta_keywords" value="3">
        <input type="hidden" name="seo_title" value="3">
        <input type="hidden" name="image" value="3">
        <input type="hidden" name="featured" value="3">

    </form>

@endsection
