@extends('events.layout')

@section('javascript')
    @parent
    javascript-create-view

@stop

{{--
@section('javascript')

    <!-- Initialize editor for the main textbox -->
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
                 });
                 $('#organizer').change(function(){
                     $('#multiple_organizers').val($('#organizer').val());
                  });

                // Datepicker & Timepicker
                    $('#datepicker_start_date input').datepicker();
                    $('#timepicker_start').timepicker();
                    $('#datepicker_end_date input').datepicker();
                    $('#timepicker_end').timepicker();

                // Event Repeat
                    $("input[name='repeatControl']").change(function(){
                        var radioVal = $("input[name='repeatControl']:checked").val();
                        alert(radioVal);
                    });


            });
        </script>

@endsection
--}}

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New event</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management')

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" class="form-control" placeholder="Event title">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-category')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-status')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Event description" id="bodyTextarea"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-teacher')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-organizer')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-event-venue')
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <legend>Start, End, Duration</legend>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-date-start')
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-time-start')
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-date-end')
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                @include('partials.forms.input-time-end')
            </div>
        </div>

        @include('partials.repeat-event')

        @include('partials.forms.image-event')

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
