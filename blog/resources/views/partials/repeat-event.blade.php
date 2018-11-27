@section('javascript-document-ready')
    @parent
    $("input[name='repeat_type']").change(function(){

        // Show and hide the repeat options
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

        // Set date end to the same day of start if is a repeat event (this is to avoid mistakes of the users that set date end to the end of repetition)
            if (radioVal =="2" || radioVal =="3"){
                var dateStart = $("input[name='startDate']").val();
                $("input[name='endDate']").val(dateStart);
                $("input[name='endDate']").datepicker('destroy');
            }

        // Re-create the datepicker_end_date that has been destroyed in case of repetition
            if (radioVal =="1"){
                var today = new Date();

                $('#datepicker_end_date input').datepicker({
                    format: 'dd/mm/yyyy',
                    startDate: today
                });
            }




        //repeatDetails
        /*
        $('.repeatTab').hide();
        $('#' + radioVal).show();

        if (radioVal =="repeatWeekly"){
            var dateStart = $("input[name='startDate']").val();
            $("input[name='endDate']").val(dateStart);
            $("input[name='endDate']").datepicker('destroy');
        }

        if (radioVal =="noRepeat"){
            var today = new Date();

            $('#datepicker_end_date input').datepicker({
                format: 'dd/mm/yyyy',
                startDate: today
            });
        }
        */


    });


@stop


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <legend>Repeat type</legend>
    </div>
</div>

<div class="row mb-3 repeatController">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary active">
                <input type="radio" name="repeat_type" value="1" checked> No repeat
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="repeat_type" value="2"> Weekly
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="repeat_type" value="3"> Monthly
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
                <label class="btn btn-primary active">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="1" autocomplete="off" checked> M
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="2" autocomplete="off"> T
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="3" autocomplete="off"> W
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="4" autocomplete="off"> T
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="5" autocomplete="off"> F
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="6" autocomplete="off"> S
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_on_day[]" value="7" autocomplete="off"> S
                </label>
            </div>
        </div>

        <div id="onMonthly" class="onFrequency col-xs-12 col-sm-6 col-lg-4" style="display:none">
            <strong>On:</strong><br/>
            aaaa
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-8 mt-2 mt-sm-0">
            {{-- <strong>Repeat Until</strong>
            <div class="form-group">
                <div class="input-group input-append date" id="datepicker_repeat_until" data-date-format="dd-mm-yyyy">
                    <input name="repeatUntil" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-end">
                    <div class="input-group-append">
                        <span class="input-group-text" id="date-addon-end"><i class="far fa-calendar"></i></span>
                    </div>
                </div>
            </div>--}}

            @include('partials.forms.input-date', [
                  'title' => 'Repeat Until',
                  'name' => 'repeat_until',
                  'placeholder' => 'Select date'//,
                  //'value' => $event->repeat_until
            ])

        </div>
    </div>
</div>


<div id="repeatMonthly" class="repeatTab" style="display:none">
    <div class="row">
        <div class="col-12">
            <legend>Monthly</legend>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <strong>On:</strong><br/>

        </div>

    </div>
</div>
