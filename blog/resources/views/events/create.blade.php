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
                 $('#organizer').change(function(){
                     $('#multiple_organizers').val($('#organizer').val());
                     //console.log($('#multiple_teachers').val());
                  });

                  // Datepicker & Timepicker
                        $('#datepicker_start_date input').datepicker();
                        $('#timepicker_start').timepicker();
                        $('#datepicker_end_date input').datepicker();
                        $('#timepicker_end').timepicker();

            });
        </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New event</h2>
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
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control">
                        <option value="">Select category</option>
                        @foreach ($eventCategories as $value => $eventCategory)
                            <option value="{{$value}}">{!! $eventCategory !!}</option>
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
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Event description" id="bodyTextarea"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group" >
                    <strong>Teachers:</strong>
                    <select id="teacher" class="selectpicker" multiple title="Select teacher">
                        @foreach ($teachers as $value => $teacher)
                            <option value="{{$value}}">{!! $teacher !!}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="multiple_teachers" id="multiple_teachers" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group" >
                    <strong>Organizers:</strong>
                    <select id="organizer" class="selectpicker" multiple title="Select organizer">
                        @foreach ($organizers as $value => $organizer)
                            <option value="{{$value}}">{!! $organizer !!}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="multiple_organizers" id="multiple_organizers" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group" >
                    <strong>Venues:</strong>
                    <select name="venue_id" class="selectpicker" title="Select venue" data-live-search="true">
                        @foreach ($venues as $value => $venue)
                            <option value="{{$venue->id}}">{!! $venue->name !!} - {!! $venue->city !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <legend>Start, End, Duration</legend>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Date Start:</strong>
                    <div class="input-group input-append date" id="datepicker_start_date" data-date-format="dd-mm-yyyy">
                        <input name="startDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-start">
                        <div class="input-group-append">
                            <span class="input-group-text" id="date-addon-start"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Time Start:</strong>
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input id="timepicker_start" type="text" class="form-control input-small" aria-describedby="time-addon-start">
                        <div class="input-group-append">
                            <span class="input-group-text" id="time-addon-start"><i class="far fa-clock"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Date End:</strong>
                    <div class="input-group input-append date" id="datepicker_end_date" data-date-format="dd-mm-yyyy">
                        <input name="endDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-end">
                        <div class="input-group-append">
                            <span class="input-group-text" id="date-addon-end"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Time End:</strong>
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input id="timepicker_end" type="text" class="form-control input-small" aria-describedby="time-addon">
                        <div class="input-group-append">
                            <span class="input-group-text" id="time-addon"><i class="far fa-clock"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <legend>Repeat type</legend>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> No Repeat
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Weekly
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Monthly
                    </label>
                </div>
            </div>
        </div>

        <div class="repeatWeekly">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <legend>Weekly</legend>
                    <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Repeat count
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" id="option2" autocomplete="off"> Repeat until
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>Repeat Count</strong>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="For how many weeks" aria-label="For how many weeks" aria-describedby="how-many-weeks">
                        <div class="input-group-append">
                            <span class="input-group-text" id="how-many-weeks">weeks</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>Repeat Until</strong>
                    <div class="form-group">
                        <div class="input-group input-append date" id="datepicker_end_date" data-date-format="dd-mm-yyyy">
                            <input name="endDate" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-end">
                            <div class="input-group-append">
                                <span class="input-group-text" id="date-addon-end"><i class="far fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="repeatMonthly">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <legend>Monthly</legend>
                    <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> By month day
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" id="option2" autocomplete="off"> By day
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>By month day</strong>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="10,25" aria-label="For how many weeks" aria-describedby="how-many-weeks">
                        <div class="input-group-append">
                            <span class="input-group-text" id="how-many-weeks">comma separated list</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <strong>By day</strong><br/>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="checkbox" name="options" id="option1" autocomplete="off" checked> M
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" name="options" id="option2" autocomplete="off"> T
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" name="options" id="option3" autocomplete="off"> W
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" name="options" id="option4" autocomplete="off"> T
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" name="options" id="option5" autocomplete="off"> F
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" name="options" id="option6" autocomplete="off"> S
                        </label>
                        <label class="btn btn-primary">
                            <input type="checkbox" name="options" id="option7" autocomplete="off"> S
                        </label>
                    </div>
                </div>
            </div>
        </div>




        <div class="row h-100 mt-3">
            <div class="col-xs-9 col-sm-9 col-md-9 pull-left my-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>Teaser Image</strong></span>
                    </div>
                    <input id="thumbnail" class="form-control" type="text" name="image">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 pull-right my-auto">
                <img id="holder" style="width:100%;">
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
