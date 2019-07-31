{{--
    TEXTAREA with tinymce editor.
        - provide some more editor buttons than the textarea partial.
        - remove the p elements and add br instead
        
    PARAMETERS:
        - $title: string - the title to show
        - $name: string - the select name attribute
        - $placeholder: string - the text shown when no text present 
        - $value: the already stored value (used in edit view to retrieve the already stored value)
--}}

@section('javascript')
    @parent

    <!-- Initialize editor for the main textbox -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" ></script>
    <script>
		// https://www.tiny.cloud/docs/get-started/basic-setup/
			var editor_config = {
				selector: 'textarea#bodyTextarea',
                
                // Don't produce p tags on enter, instead produce <br />
                    //forced_root_block : '', 
                    //force_br_newlines : true, 
                    //force_p_newlines : false, 
                
                // Remove Html tags from paste text
                    paste_as_text: true, //!important
                
                // Allow link target blank
                    extended_valid_elements: 'a[href|target],pre[class],code',
                        
				/*plugins : 'advlist autolink link image lists charmap print preview spellchecker media table',*/
				plugins: [
				 "advlist autolink lists link image charmap print preview hr anchor pagebreak",
				 "searchreplace wordcount visualblocks visualchars code fullscreen",
				 "insertdatetime media nonbreaking save table contextmenu directionality",
				 "emoticons template paste textcolor colorpicker textpattern codesample"
			   ],
				theme: 'modern',
				height: 400,
				{{-- toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | blockquote | link image media  | hr', --}}
                codesample_languages: [
            		{text: 'HTML/XML', value: 'markup'},
            		{text: 'JavaScript', value: 'javascript'},
            		{text: 'CSS', value: 'css'},
            		{text: 'PHP', value: 'php'},
            	],
                toolbar: 'bold italic | styleselect | bullist numlist | link image | hr blockquote codesample | code ',
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

<div class="form-group {{ $name }}">
    <label for="{{ $name }}">{{ $title }}@if($required) <span class="dark-gray" data-toggle="tooltip" data-placement="top" title="@lang('views.required')">*</span>@endif</label>
    <textarea class="form-control" style="height:150px" name="{{ $name }}" placeholder="{{ $placeholder }}" id="bodyTextarea">@if(!empty($value)){!! $value !!} @endif</textarea>
</div>
