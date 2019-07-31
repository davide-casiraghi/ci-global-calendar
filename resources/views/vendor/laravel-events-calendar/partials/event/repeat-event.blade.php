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
                        $('.repeatUntilSelector').hide();
                    break;
                    case '2':  // Repeat Weekly
                        $('.repeatDetails').show();
                        $('.onFrequency').hide();
                        $('#onWeekly').show();
                        $('.repeatUntilSelector').show();
                    break;
                    case '3':  // Repeat Monthly
                        $('.repeatDetails').show();
                        $('.onFrequency').hide();
                        $('#onMonthly').show();
                        $('.repeatUntilSelector').show();
                    break;
                    case '4':  // Repeat Multiple
                        $('.repeatDetails').show();
                        $('.onFrequency').hide();
                        $('#onMultiple').show();
                        $('.repeatUntilSelector').hide();
                    break;
                }

            {{-- Set date end to the same day of start if is a repeat event (this is to avoid mistakes of the users that set date end to the end of repetition) --}}
                if (radioVal =="2" || radioVal =="3" || radioVal =="4"){
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

    {{-- POPULATE the select "Monthly on" options - when the edit view is open --}}
        function updateMonthlySelectOptions(){
            
            var montlyOnSelected = $("input[name='on_monthly_kind_value']").val();
            
            var request = $.ajax({
                url: "/event/monthSelectOptions",
                data: {
                    day: $("input[name='startDate']").val()
                },
                success: function( data ) {
                    $("#on_monthly_kind").html(data);
                    $("#on_monthly_kind").selectpicker('refresh');
                    $("#on_monthly_kind").selectpicker('val', montlyOnSelected);
                }
            });

        }

@stop


<div class="row">
    <div class="col-12">
        <h5>@lang('laravel-events-calendar::event.repeat_type')</h5>
    </div>
</div>

<div class="row mb-3 repeatController">
    <div class="col-12">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 1 ? 'active' : '' }} @else {{'active'}} @endif ">
                <input type="radio" name="repeat_type" value="1" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 1 ? 'checked' : '' }} @else {{'checked'}} @endif> @lang('laravel-events-calendar::event.no_repeat')
            </label>
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 2 ? 'active' : '' }} @endif ">
                <input type="radio" name="repeat_type" value="2" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 2 ? 'checked' : '' }}@endif> @lang('laravel-events-calendar::event.weekly')
            </label>
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 3 ? 'active' : '' }} @endif ">
                <input type="radio" name="repeat_type" value="3" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 3 ? 'checked' : '' }}@endif> @lang('laravel-events-calendar::event.monthly')
            </label>
            <label class="btn btn-primary @if(!empty($event->repeat_type)) {{ $event->repeat_type == 4 ? 'active' : '' }} @endif ">
                <input type="radio" name="repeat_type" value="4" @if(!empty($event->repeat_type)) {{ $event->repeat_type == 4 ? 'checked' : '' }}@endif> @lang('laravel-events-calendar::event.multiple')
            </label>
        </div>
    </div>
</div>

<div class="repeatDetails" style="display:none">
    
    <div class="row">
        <div id="onWeekly" class="onFrequency col-12 col-xl-7" style="display:none">
            <label>@lang('laravel-events-calendar::event.weekly_on') <span data-toggle="tooltip" data-placement="top" title="@lang('laravel-events-calendar::general.required')">*</span></label><br/>
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

        <div id="onMonthly" class="onFrequency col-12 col-xl-7" style="display:none">
            <label>@lang('laravel-events-calendar::event.monthly') *</label>
            <select name="on_monthly_kind" id="on_monthly_kind" class="selectpicker" title="Select repeat monthly kind">
                <option value="1">1</option>
            </select>
            <input type="hidden" name="on_monthly_kind_value" @if(!empty($event->on_monthly_kind))  value="{{$event->on_monthly_kind}}" @endif/>
        </div>
        
        <div id="onMultiple" class="onFrequency col-12 col-xl-7" style="display:none">
            @include('laravel-form-partials::input-date-multiple', [
                  'title' => __('laravel-events-calendar::event.multiple_dates'),
                  'name' => 'multiple_dates',
                  'placeholder' => __('laravel-events-calendar::event.select_multiple_dates'),
                  'endDate' => '+1y',
                  'value' => $dateTime['multipleDates'],
                  'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                  'tooltipText' => __('laravel-events-calendar::event.select_multiple_dates'),
                  'required' => false,
            ])
        </div>

        <div class="col-12 col-xl-5 mt-3 mt-xl-0 repeatUntilSelector" style="display:none">

            @include('laravel-form-partials::input-date', [
                  'title' => __('laravel-events-calendar::event.repeat_until'),
                  'name' => 'repeat_until',
                  'placeholder' => __('laravel-events-calendar::general.select_date'),
                  'endDate' => '+1y',
                  'value' => $dateTime['repeatUntil'],
                  'tooltipFontAwesomeClass' => 'fa fa-info-circle',
                  'tooltipText' => __('laravel-events-calendar::event.max_until'),
                  'required' => true,
            ])

        </div>
    </div>
</div>
