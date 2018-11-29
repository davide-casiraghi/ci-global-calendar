@section('javascript-document-ready')
    @parent

    {{-- ON LOAD --}}

    {{-- SET the week days saved - when the edit view is open  --}}
        var weekDaysSelected = $('#repeat_weekly_on').val();
        if (weekDaysSelected){
            var weekDaysSelectedArray = weekDaysSelected.split(',');
            for (i = 0; i < weekDaysSelectedArray.length; ++i) {
                $('#onWeekly label#day_'+ weekDaysSelectedArray[i]).addClass('active');
                $('#onWeekly label#day_'+ weekDaysSelectedArray[i]+' input' ).attr('checked', true);
            }
        }

    {{-- SET the repeat values, show and hide the repeat options - when the edit view is open --}}
        setRepeatValues();

    {{-- ON CHANGE --}}

    {{-- SET the repeat values, show and hide the repeat options - when repeat type is changed --}}
        $("input[name='repeat_type']").change(function(){
            setRepeatValues();
        });

    {{-- UPDATE monthly select options every time the start date is changed --}}
        $("input[name='startDate']").change(function(){
            updateMonthlySelectOptions();
        });


    {{-- FUNCTIONS --}}

    {{-- Show and hide the repeat options --}}
        function setRepeatValues(radioVal) {
                var radioVal = $("input[name='repeat_type']:checked").val();
                switch(radioVal) {
                    case '1':  // No Repeat
                        $('.repeatDetails').hide();
                    break;
                    case '2':  // Repeat Weekly
                        $('.repeatDetails').show();
                        $('.onFrequency').hide();
                        $('#onWeekly').show();
                    break;
                    case '3':  // Repeat Monthly
                        $('.repeatDetails').show();
                        $('.onFrequency').hide();
                        $('#onMonthly').show();
                    break;
                }

            {{-- Set date end to the same day of start if is a repeat event (this is to avoid mistakes of the users that set date end to the end of repetition) --}}
                if (radioVal =="2" || radioVal =="3"){
                    var dateStart = $("input[name='startDate']").val();
                    $("input[name='endDate']").val(dateStart);
                    $("input[name='endDate']").datepicker('destroy');
                }

            {{-- Re-create the datepicker_end_date that has been destroyed in case of repetition --}}
                if (radioVal =="1"){
                    var today = new Date();

                    $('#datepicker_end_date input').datepicker({
                        format: 'dd/mm/yyyy',
                        startDate: today
                    });
                }

                if (radioVal =="3"){
                    updateMonthlySelectOptions();
                }
        }

    {{-- UPDATE the select month options --}}
        function updateMonthlySelectOptions(){

            var request = $.ajax({
                url: "/event/monthSelectOptions",
                data: {
                    day: $('#datepicker_start_date input').val()
                },
                success: function( data ) {
                    $("#on_monthly_kind").html(data).selectpicker('refresh');
                }
            });

        }

            /*

            if (radioVal =="noRepeat"){
                var today = new Date();

                $('#datepicker_end_date input').datepicker({
                    format: 'dd/mm/yyyy',
                    startDate: today
                });
            }
            */

@stop


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <legend>Repeat type</legend>
    </div>
</div>

<div class="row mb-3 repeatController">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 1 ? 'active' : '' }} @else {{'active'}} @endif ">
                <input type="radio" name="repeat_type" value="1" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 1 ? 'checked' : '' }} @else {{'checked'}} @endif> No repeat
            </label>
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 2 ? 'active' : '' }} @endif ">
                <input type="radio" name="repeat_type" value="2" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 2 ? 'checked' : '' }}@endif> Weekly
            </label>
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 3 ? 'active' : '' }} @endif ">
                <input type="radio" name="repeat_type" value="3" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 3 ? 'checked' : '' }}@endif> Monthly
            </label>
        </div>
    </div>
</div>

<div class="repeatDetails" style="display:none">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <legend>Weekly</legend>
        </div>
    </div>

    <div class="row">

        <div id="onWeekly" class="onFrequency col-xs-12 col-sm-6 col-lg-4" style="display:none">
            <strong>On:</strong><br/>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary" id="day_1" >
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="1" autocomplete="off"> M
                </label>
                <label class="btn btn-primary" id="day_2">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="2" autocomplete="off"> T
                </label>
                <label class="btn btn-primary" id="day_3">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="3" autocomplete="off"> W
                </label>
                <label class="btn btn-primary" id="day_4">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="4" autocomplete="off"> T
                </label>
                <label class="btn btn-primary" id="day_5">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="5" autocomplete="off"> F
                </label>
                <label class="btn btn-primary" id="day_6">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="6" autocomplete="off"> S
                </label>
                <label class="btn btn-primary" id="day_7">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="7" autocomplete="off"> S
                </label>
            </div>
            <input type="hidden" name="repeat_weekly_on" id="repeat_weekly_on" @if(!empty($event->repeat_weekly_on))  value="{{$event->repeat_weekly_on}}" @endif/>
        </div>

        <div id="onMonthly" class="onFrequency col-xs-12 col-sm-6 col-lg-4" style="display:none">
            <strong>On:</strong><br/>
            <select name="on_monthly_kind" id="on_monthly_kind" class="selectpicker" title="Select repeat monthly kind">
                <option value="1">1</option>
            </select>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-8 mt-2 mt-sm-0">

            @include('partials.forms.input-date', [
                  'title' => 'Repeat Until',
                  'name' => 'repeat_until',
                  'placeholder' => 'Select date',
                  'value' => $dateTime['repeatUntil']
            ])

        </div>
    </div>
</div>
