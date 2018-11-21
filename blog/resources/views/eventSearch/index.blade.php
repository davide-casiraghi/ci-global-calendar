{{-- @extends('layouts.app') --}}
@extends('layouts.hpEventSearch')

@section('javascript-document-ready')
    @parent

    {{-- Clear filters on click reset button --}}
    $("#resetButton").click(function(){
        $("input#keywords").val("");
        $('#category option').prop("selected", false).trigger('change');
        $('#teacher option').prop("selected", false).trigger('change');
        $('#country option').prop("selected", false).trigger('change');
        $('#continent option').prop("selected", false).trigger('change');
        $('form#searchForm').submit();
    });

    {{-- BACKGROUND IMAGES --}}



@stop

@section('javascript')
    @parent

    <script>
    // Detect mobile devices - https://stackoverflow.com/questions/11381673/detecting-a-mobile-browser#11381730
	window.mobilecheck = function() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	};

	window.mobileAndTabletcheck = function() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	};

    // Change background
        $(function() {

            var element = $('.contactEvents');

            // Create background array
                var backgrounds = new Array();
                var base_url = window.location.origin;

                // Image path is different for desktop and mobile devices (for mobile vertical and smaller images are provided)
                    if ((mobilecheck())&&( window.orientation == 0)){
                        // Mobile and vertical - 305x550
                            @foreach ($backgroundImages as $key_1 => $backgroundImage)
                                @if($backgroundImage->orientation == 1)
                                    backgrounds[{{$key_1}}] = 'url('+'{{$backgroundImage->image_src}}'+')';
                                @endif
                            @endforeach
                    }
                    else{
                        // Desktop - 1100x733 65% quality
                            @foreach ($backgroundImages as $key => $backgroundImage)
                                @if($backgroundImage->orientation == 0)
                                    backgrounds[{{$loop->index}}] = 'url('+'{{$backgroundImage->image_src}}'+')';
                                @endif
                            @endforeach
                    }


                /*for(var i=0; i<images.length; i++){
                    backgrounds[i] = 'url('+base_url + image_path + images[i]+')';
                }*/

            // Function to change background
                var current = 0;
                function nextBackground() {
                    element.css(
                        'background-image',
                        backgrounds[current = ++current % backgrounds.length]
                    );

                    setTimeout(nextBackground, 10000);
                }

                setTimeout(nextBackground, 10000);

                element.css('background-image', backgrounds[0]);

        });
    </script>

@stop

@section('beforeContent')
    {{--@include('partials.jumboBackgroundChange')--}}
    <div class="contactEvents jumbotron" style="background-image: url(&quot;http://www.globalcicalendar.com/components/com_contactevents/assets/images/image_5.jpg&quot;);">

        <div class="contents">
            <div class="row eventFormTitle">
                <div class="col-lg-12 text-center">
                    <h1 class="text-white mb-3">Contact Improvisation</h1>
                    <h4 class="text-secondary text-uppercase">- Global calendar -</h4>
                    <p class="subtitle text-white">
                        Find information about Contact Improvisation events worldwide (classes, jams, workshops, festivals and more)<br>WE ARE UNDER CONSTRUCTION, calendar is still in beta testing phase, we plan to fully operate starting from January 2019 on
                    </p>
                    <p class="searchHere text-white mt-5">
                        Search here with one criteria or more
                    </p>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-4">
                    <p>{{ $message }}</p>
                </div>
            @endif

            {{-- Search form --}}
            <form id="searchForm" action="{{ route('eventSearch.index') }}" method="GET">
                @csrf

                {{--<div class="row mt-3">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Search by event name" value="{{ $searchKeywords }}">
                    </div>
                </div>--}}

                <div class="row">
                    <div class="col-md-4">
                        <p><strong class="text-white">What</strong></p>
                        @include('partials.forms.event-search.select-category')

                        <p class="mt-3"><strong class="text-white">Who</strong></p>
                        @include('partials.forms.event-search.select-teacher')
                    </div>
                    <div class="col-md-4">
                        <p><strong class="text-white">Where</strong></p>
                        @include('partials.forms.event-search.select-continent')
                        @include('partials.forms.event-search.select-country')
                        <p class="mt-3"><strong class="text-white">Search by name of venue only</strong></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong class="text-white">When</strong></p>
                        @include('partials.forms.event-search.input-date-start')
                        @include('partials.forms.event-search.input-date-end')
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-sm-10 mt-3">
                        <a id="resetButton" class="btn btn-info float-right ml-2" href="#">Reset</a>
                        <input type="submit" value="Search" class="btn btn-primary float-right">
                    </div>
                </div>
            </form>

            {{-- List of events --}}
            {{--<table class="table table-bordered mt-4">
                <tr>
                    <th>Title</th>
                    <th>Teachers</th>
                    <th>Category</th>
                    <th>Venue</th>
                </tr>
                @foreach ($events as $event)
                <tr>
                    <td><a href="{{ route('eventSearch.show',$event->id) }}">{{ $event->title }}</a></td>
                    <td>{{ $event->sc_teachers_names }}</td>
                    <td>{{ $eventCategories[$event->category_id] }}</td>
                    <td>
                        {{ $event->sc_venue_name }}<br />
                        {{ $event->sc_city_name }},
                        {{ $event->sc_country_name }}
                    </td>
                </tr>
                @endforeach
            </table>
        --}}



            <div class="eventList mt-5">
                @foreach ($events as $event)
                    <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                        <div class="col-lg-1 date">
                            <div class="row text-uppercase">

                            {{-- One day event --}}
                            @if (@date($event->start_repeat)==@date($event->end_repeat))
                                <div class='dateBox col bg-secondary text-white px-2 vcenter' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                                    <strong>
                                        @day($event->start_repeat)
                                        @month($event->start_repeat)
                                    </strong>
                                </div>
                            {{-- Many days event --}}
                            @else
                                <div class='col text-center bg-secondary text-white px-1 mr-1' data-toggle="tooltip" data-placement="top" title="@date($event->start_repeat)">
                                    <strong>
                                        @day($event->start_repeat)
                                        @month($event->start_repeat)
                                    </strong>
                                </div>
                                <div class='col text-center bg-secondary text-white px-1' data-toggle="tooltip" data-placement="top" title="@date($event->end_repeat)">
                                    <strong>
                                        @day($event->end_repeat)
                                        @month($event->end_repeat)
                                    </strong>
                                </div>
                            @endif
                            </div>
                        </div>
                        <div class="col-md-3 py-3 py-md-0 vcenter title">
                            <a href="{{ route('eventSearch.show',$event->id) }}">{{ $event->title }}</a>
                        </div>
                        <div class="col-md-2 vcenter teachers">
                            @if(!empty($event->sc_teachers_names))
                            <i data-toggle="tooltip" data-placement="top" title="Teachers" class="far fa-users mr-2"></i>
                            {{ $event->sc_teachers_names }}
                            @endif
                        </div>
                        <div class="col-md-2 vcenter category mt-2 mt-md-0">
                            <i data-toggle="tooltip" data-placement="top" title="Category" class="fa fa-tag mr-2"></i>
                            {{ $eventCategories[$event->category_id] }}
                        </div>
                        <div class="col-md-3 vcenter location mt-2 mt-md-0">
                            <i data-toggle="tooltip" data-placement="top" title="Venue" class="far fa-map-marker-alt mr-2" style="display: table-cell; vertical-align: middle; width: 20px; text-align: center;"></i>
                            {{ $event->sc_venue_name }}<br />
                            {{ $event->sc_city_name }},
                            {{ $event->sc_country_name }}
                        </div>
                        <div class="col-md-1 vcenter facebook mt-2 mt-md-0">
                            @if(!empty($event->facebook_event_link))
                                <a href='{{ $event->facebook_event_link }}' target='_blank'><i class='fab fa-facebook-square' data-toggle="tooltip" data-placement="top" title="Facebook event"></i></a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {!! $events->links() !!}

        </div>
        <div class="bg-overlay"></div>


    </div>

@endsection

{{--
@section('content')

@endsection
--}}
