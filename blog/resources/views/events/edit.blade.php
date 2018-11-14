@extends('events.layout')


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

        <script type="text/javascript">
            $(document).ready(function(){
                $('#teacher').change(function(){
                    $('#multiple_teachers').val($('#teacher').val());
                    //console.log($('#multiple_teachers').val());
                 });
            });
        </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit event</h2>
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


    <form action="{{ route('events.update',$event->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" class="form-control" placeholder="Event title" value="{{ $event->title }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control">
                        @foreach ($eventCategories as $value => $eventCategory)
                            <option value="{{$value}}" {{ $event->category_id == $value ? 'selected' : '' }}>{!! $eventCategory !!} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>

                    <select name="status" class="form-control">
                        <option value="PUBLISHED" selected>Published</option>
                        <option value="DRAFT">Draft</option>
                        <option value="PENDING">Pending</option>
                    </select>

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Event description" id="bodyTextarea">{{ $event->description }}</textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group" >
                    <strong>Teachers:</strong>
                    <select id="teacher" class="selectpicker" multiple>
                        @foreach ($teachers as $value => $teacher)
                            <option value="{{$value}}">{!! $teacher !!}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="multiple_teachers" id="multiple_teachers" />
                </div>
            </div>

        </div>

        <div class="row h-100 mt-3">
            <div class="col-xs-9 col-sm-9 col-md-9 pull-left my-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>Intro Image</strong></span>
                    </div>
                    <input id="thumbnail" class="form-control" type="text" name="image" value="{{ $event->image }}">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 pull-right my-auto">
                <img id="holder" src="{{ $event->image }}" style="width:100%;">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('events.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


        <!--<input type="hidden" name="author_id" value="1">
        <input type="hidden" name="image" value="3">-->


    </form>

@endsection
