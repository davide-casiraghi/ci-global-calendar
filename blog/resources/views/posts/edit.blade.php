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
				toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | blockquote | link image media',



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
                <h2>Edit post</h2>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('posts.update',$post->id) }}" method="POST">
        @csrf
        @method('PUT')


         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" value="{{ $post->title }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $value => $category)
                            <option value="{{$value}}">{!! $category !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Body:</strong>
                    <textarea class="form-control" style="height:150px" name="body" placeholder="Detail" id="bodyTextarea">{{ $post->body }}</textarea>
                </div>
            </div>
        </div>

        <div class="row h-100 mt-3">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left my-auto">
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
            <div class="col-xs-3 col-sm-3 col-md-3 pull-right my-auto">
                <input type="text" name="introimage_alt" value="{{ $post->introimage_alt }}" class="form-control" placeholder="Alt">
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 pull-right my-auto">
                <img id="holder" src="{{ $post->introimage_src }}" style="width:100%;">
            </div>
        </div>



        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>



@endsection
