{{-- 
    textarea-post partial provide the tinymce editor with some more buttons than the textarea partial.
--}}

@section('javascript')
    @parent

    <!-- Initialize editor for the main textbox -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" ></script>
    <script>
		// https://www.tiny.cloud/docs/get-started/basic-setup/
			var editor_config = {
				selector: 'textarea#bodyTextarea',
                extended_valid_elements: 'a[href|target=_blank]',
				/*plugins : 'advlist autolink link image lists charmap print preview spellchecker media table',*/
				plugins: [
				 "advlist autolink lists link image charmap print preview hr anchor pagebreak",
				 "searchreplace wordcount visualblocks visualchars code fullscreen",
				 "insertdatetime media nonbreaking save table contextmenu directionality",
				 "emoticons template paste textcolor colorpicker textpattern"
			   ],
				theme: 'modern',
				height: 400,
				{{-- toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | blockquote | link image media  | hr', --}}
                toolbar: 'bold italic | styleselect | bullist numlist | link image | hr | code',
                menubar: false,
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
@stop

<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <textarea class="form-control" style="height:150px" name="{{ $name }}" placeholder="{{ $placeholder }}" id="bodyTextarea">@if(!empty($value)){!! $value !!} @endif</textarea>
</div>
