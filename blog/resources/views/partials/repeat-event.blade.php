@section('javascript-document-ready')
    @parent
    $("input[name='repeatControl']").change(function(){
        var radioVal = $("input[name='repeatControl']:checked").val();
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
    });


@stop


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <legend>Repeat type</legend>
    </div>
</div>

<div class="row mb-3">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary active">
                <input type="radio" name="repeatControl" value="noRepeat" id="option1" autocomplete="off" checked> None
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="repeatControl" value="repeatWeekly" id="option2" autocomplete="off"> Weekly
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="repeatControl" value="repeatMonthly" id="option3" autocomplete="off"> Monthly
            </label>
        </div>
    </div>
</div>

<div id="repeatWeekly" class="repeatTab" style="display:none">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <legend>Weekly</legend>
            {{--<div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input type="radio" name="options" id="option1" autocomplete="off" checked> Repeat count
                </label>
                <label class="btn btn-primary">
                    <input type="radio" name="options" id="option2" autocomplete="off"> Repeat until
                </label>
            </div>--}}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <strong>By day</strong><br/>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="1" autocomplete="off" checked> M
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="2" autocomplete="off"> T
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="3" autocomplete="off"> W
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="4" autocomplete="off"> T
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="5" autocomplete="off"> F
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="6" autocomplete="off"> S
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" name="repeat_weekly_by_day[]" value="7" autocomplete="off"> S
                </label>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xs-1 col-sm-1 col-md-1 col-xs-1 text-center align-self-center">
            <input type="radio" name="repeat_week_kind" value="repeat_count" aria-label="Radio button for following text input">
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-xs-5">
            <strong>Repeat Count</strong>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="how_many_weeks" placeholder="For how many weeks" aria-label="For how many weeks" aria-describedby="how-many-weeks">
                <div class="input-group-append">
                    <span class="input-group-text" id="how-many-weeks">weeks</span>
                </div>
            </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-xs-1 text-center align-self-center">
            <input type="radio" name="repeat_week_kind" value="repeat_until" aria-label="Radio button for following text input">
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-xs-1">
            <strong>Repeat Until</strong>
            <div class="form-group">
                <div class="input-group input-append date" id="datepicker_end_date" data-date-format="dd-mm-yyyy">
                    <input name="repeatUntil" class="form-control" type="text" placeholder="Select date" value="" readonly="readonly" aria-describedby="date-addon-end">
                    <div class="input-group-append">
                        <span class="input-group-text" id="date-addon-end"><i class="far fa-calendar"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="repeatMonthly" class="repeatTab" style="display:none">
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
