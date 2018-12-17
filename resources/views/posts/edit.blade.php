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
				toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | blockquote | link image media | hr',



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
                <h2>@lang('views.edit_post')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('posts.update',$post->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Title',
                    'name' => 'title',
                    'placeholder' => 'Event title',
                    'value' => $post->title
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Slug:</strong>
                    <input type="text" name="slug" value="{{ $post->slug }}" class="form-control" placeholder="Slug">
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.category'),
                    'name' => 'category_id',
                    'placeholder' => __('views.select_category'),
                    'records' => $categories,
                    'seleted' => $post->category_id
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.before_post_contents'),
                    'name' => 'before_content',
                    'value' => $post->before_content,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-post', [
                    'title' => 'Text',
                    'name' => 'body',
                    'placeholder' => 'Post text',
                    'value' => $post->body
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.after_post_contents'),
                     'name' => 'before_content',
                     'value' => $post->after_content,
                ])
            </div>
        </div>

        <div class="row h-100 mt-3">
            <div class="col-6 pull-left my-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>Intro Image</strong></span>
                    </div>
                    <input id="thumbnail" class="form-control" type="text" name="introimage_src" value="{{ $post->introimage_src }}">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-3 col-sm-3 col-md-3 pull-right my-auto">
                <input type="text" name="introimage_alt" value="{{ $post->introimage_alt }}" class="form-control" placeholder="Alt">
            </div>
            <div class="col-3 col-sm-3 col-md-3 pull-right my-auto">
                <img id="holder" src="{{ $post->introimage_src }}" style="width:100%;">
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'posts.index'  
        ])

    </form>



@endsection
