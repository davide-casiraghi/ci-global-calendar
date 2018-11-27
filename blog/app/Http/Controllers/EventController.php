<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\EventRepetition;
use App\Teacher;
use App\Organizer;
use App\EventVenue;
use App\Country;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReportMisuse;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DateTime;
use DateInterval;
use DatePeriod;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $eventCategories = EventCategory::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $venues = EventVenue::pluck( 'country_id', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');
        $searchCountry = $request->input('country_id');

        // Show just to the owner - Get created_by value if the user is not an admin or super admin
        $user = Auth::user();
        $createdBy = (!$user->isSuperAdmin()&&!$user->isAdmin()) ? $user->id : 0;

        if ($searchKeywords||$searchCategory||$searchCountry){
            $events = DB::table('events')
                ->when(isset($createdBy), function ($query, $createdBy) {
                    return $query->where('created_by', $createdBy);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('category_id', '=', $searchCategory);
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->join('event_venues', 'events.venue_id', '=', 'event_venues.id')->where('event_venues.country_id', '=', $searchCountry);
                })
                ->paginate(20);
        }
        else
            $events = Event::latest()
                ->when($createdBy, function ($query, $createdBy) {
                    return $query->where('created_by', $createdBy);
                })->paginate(20);

        return view('events.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('eventCategories',$eventCategories)->with('countries', $countries)->with('venues', $venues)->with('searchKeywords',$searchKeywords)->with('searchCategory',$searchCategory)->with('searchCountry',$searchCountry);
    }

    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $eventCategories = EventCategory::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $organizers = Organizer::pluck('name', 'id');
        //$venues = EventVenue::pluck('name', 'id');
        $venues = DB::table('event_venues')
                ->select('id','name','city')->get();

        $dateTime['repeatUntil'] = null;

        //return view('events.create');
        return view('events.create')
        ->with('eventCategories', $eventCategories)
        ->with('teachers', $teachers)
        ->with('organizers', $organizers)
        ->with('venues', $venues)
        ->with('dateTime',$dateTime);
    }

    /***************************************************************************/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $event = new Event();

        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'venue_id' => 'required',
        ]);

        $countries = Country::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        $venue = DB::table('event_venues')
                ->select('event_venues.id AS venue_id', 'event_venues.name AS venue_name', 'event_venues.country_id AS country_id', 'event_venues.continent_id', 'event_venues.city')
                ->where('event_venues.id', '=', $request->get('venue_id'))
                ->first();

        $event->title = $request->get('title');
        $event->description = $request->get('description');
        $event->created_by = \Auth::user()->id;
        $event->slug = str_slug($event->title, '-').rand(100000, 1000000);
        $event->category_id = $request->get('category_id');
        $event->venue_id = $request->get('venue_id');
        $event->image = $request->get('image');
        $event->facebook_event_link = $request->get('facebook_event_link');
        $event->status = $request->get('status');

        // Support columns for homepage search
            $event->sc_country_id = $venue->country_id;
            $event->sc_country_name = $countries[$venue->country_id];
            $event->sc_city_name = $venue->city;
            $event->sc_venue_name = $venue->venue_name;
            $event->sc_teachers_id = $request->get('multiple_teachers');
            $event->sc_continent_id = $venue->continent_id;

        // Multiple teachers
            if($request->get('multiple_teachers')){
                $multiple_teachers = explode(',', $request->get('multiple_teachers'));
                $i = 0; $len = count($multiple_teachers); // to put "," to all items except the last
                foreach ($multiple_teachers as $key => $teacher_id) {
                    $event->sc_teachers_names .= $teachers[$teacher_id];
                    if ($i != $len - 1)  // not last
                        $event->sc_teachers_names .= ", ";
                    $i++;
                }
            }

        // Set the Event attributes about repeating (repeat until field and multiple days)
            $event = $this->setEventRepeatFields($request, $event);

        // Save event and repetitions
            $event->save();
            $this->saveEventRepetitions($request, $event);

        // Update multi relationships with teachers and organizers tables.
            if ($request->get('multiple_teachers')){
                $multiple_teachers= explode(',', $request->get('multiple_teachers'));
                $event->teachers()->sync($multiple_teachers);
            }
            if ($request->get('multiple_organizers')){
                $multiple_organizers= explode(',', $request->get('multiple_organizers'));
                $event->organizers()->sync($multiple_organizers);
            }

        return redirect()->route('events.index')
                        ->with('success','Event created successfully.');
    }

    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, Request $request){

        $category = EventCategory::find($event->category_id);
        $teachers = $event->teachers()->get();
        $organizers = $event->organizers()->get();

        $venue = DB::table('event_venues')
                ->select('id','name','city','address','zip_code','country_id')
                ->where('id',$event->venue_id)
                ->first();

        $country = DB::table('countries')
                ->select('id','name','continent_id')
                ->where('id',$venue->country_id)
                ->first();

        $continent = DB::table('continents')
                ->select('id','name')
                ->where('id',$country->continent_id)
                ->first();

        $datesTimes = DB::table('event_repetitions')
                ->select('start_repeat','end_repeat')
                ->where('event_id',$event->id)
                ->when($request->rp_id, function ($query, $rp_id) {
                    return $query->where('id', $rp_id);
                })
                ->first();
        return view('events.show',compact('event'))->with('category', $category)->with('teachers', $teachers)->with('organizers', $organizers)->with('venue', $venue)->with('country', $country)->with('continent', $continent)->with('datesTimes', $datesTimes);
    }

    /***************************************************************************/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event){
        $eventCategories = EventCategory::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $organizers = Organizer::pluck('name', 'id');
        //$venues = EventVenue::pluck('name', 'id');
        $venues = DB::table('event_venues')
                ->select('id','name','address','city')->get();
                //dd($venues);

        $eventFirstRepetition = DB::table('event_repetitions')
                ->select('id','start_repeat','end_repeat')
                ->where('event_id','=',$event->id)
                ->first();

                //aaaaa
                //dd(date("d/m/Y", strtotime($eventFirstRepetition->start_repeat)));

        $dateTime['dateStart'] = date("d/m/Y", strtotime($eventFirstRepetition->start_repeat));
        $dateTime['dateEnd'] = date("d/m/Y", strtotime($eventFirstRepetition->end_repeat));
        $dateTime['timeStart'] = date("g:i A", strtotime($eventFirstRepetition->start_repeat));
        $dateTime['timeEnd'] = date("g:i A", strtotime($eventFirstRepetition->end_repeat));
        $dateTime['repeatUntil'] = date("d/m/Y", strtotime($event->repeat_until));

        // GET Multiple teachers
            $teachersDatas = $event->teachers;
            $teachersSelected = array();
            foreach ($teachersDatas as $teacherDatas) {
                array_push($teachersSelected, $teacherDatas->id);
            }
            $multiple_teachers = implode(',', $teachersSelected);
            //dd($multiple_teachers);

        // GET Multiple Organizers
            $organizersDatas = $event->organizers;
            //dump($organizersDatas);
            $organizersSelected = array();
            foreach ($organizersDatas as $organizerDatas) {
                array_push($organizersSelected, $organizerDatas->id);
            }
            $multiple_organizers = implode(',', $organizersSelected);

        return view('events.edit',compact('event'))
                    ->with('eventCategories', $eventCategories)
                    ->with('teachers', $teachers)
                    ->with('multiple_teachers', $multiple_teachers)
                    ->with('organizers', $organizers)
                    ->with('multiple_organizers', $multiple_organizers)
                    ->with('venues', $venues)
                    ->with('dateTime',$dateTime);
    }

    /***************************************************************************/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event){
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'venue_id' => 'required',
        ]);

        /*$event->update($request->all());*/

        $countries = Country::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        $venue = DB::table('event_venues')
                ->select('event_venues.id AS venue_id', 'event_venues.name AS venue_name', 'event_venues.country_id AS country_id', 'event_venues.continent_id', 'event_venues.city')
                ->where('event_venues.id', '=', $request->get('venue_id'))
                ->first();

        $event->title = $request->get('title');
        $event->description = $request->get('description');
        $event->created_by = \Auth::user()->id;
        $event->slug = str_slug($event->title, '-').rand(100000, 1000000);
        $event->category_id = $request->get('category_id');
        $event->venue_id = $request->get('venue_id');
        $event->image = $request->get('image');
        $event->facebook_event_link = $request->get('facebook_event_link');
        $event->website_event_link = $request->get('website_event_link');
        $event->status = $request->get('status');

        // Support columns for homepage search
            $event->sc_country_id = $venue->country_id;
            $event->sc_country_name = $countries[$venue->country_id];
            $event->sc_city_name = $venue->city;
            $event->sc_venue_name = $venue->venue_name;
            $event->sc_teachers_id = $request->get('multiple_teachers');
            $event->sc_continent_id = $venue->continent_id;

            if($request->get('multiple_teachers')){
                $multiple_teachers= explode(',', $request->get('multiple_teachers'));
                $event->sc_teachers_names = "";
                foreach ($multiple_teachers as $key => $teacher_id) {
                    $event->sc_teachers_names .= $teachers[$teacher_id];
                    if ($key === key($multiple_teachers))
                        $event->sc_teachers_names .= ", ";
                }
            }

        // Set the Event attributes about repeating (repeat until field and multiple days)
            $event = $this->setEventRepeatFields($request, $event);

        // Save event and repetitions
            $event->save();
            $this->saveEventRepetitions($request, $event);

        // Update multi relationships with teachers and organizers tables.
            if ($request->get('multiple_teachers')){
                $multiple_teachers= explode(',', $request->get('multiple_teachers'));
                $event->teachers()->sync($multiple_teachers);
            }
            if ($request->get('multiple_organizers')){
                $multiple_organizers= explode(',', $request->get('multiple_organizers'));
                $event->organizers()->sync($multiple_organizers);
            }

        return redirect()->route('events.index')
                        ->with('success','Event updated successfully');
    }

    /***************************************************************************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event){

        $eventFirstRepetition = DB::table('event_repetitions')
                //->where('active', 0)->delete();
                ->where('event_id',$event->id)
                ->delete();

        $event->delete();

        return redirect()->route('events.index')
                        ->with('success','Event deleted successfully');
    }

    /***************************************************************************/
    /**
     * To save event repetitions for create and update methods
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return none
     */

    function saveEventRepetitions($request, $event){

        $this->deletePreviousRepetitions($event->id);

        // Saving repetitions - If it's a single event will be stored with just one repetition
            $timeStart = date("H:i:s", strtotime($request->get('time_start')));
            $timeEnd = date("H:i:s", strtotime($request->get('time_end')));
            switch($request->get('repeat_type')){
                case '1':  // noRepeat
                    $eventRepetition = new EventRepetition();
                    $eventRepetition->event_id = $event->id;

                    $dateStart = implode("-", array_reverse(explode("/",$request->get('startDate'))));
                    $dateEnd = implode("-", array_reverse(explode("/",$request->get('endDate'))));

                    $eventRepetition->start_repeat = $dateStart." ".$timeStart;
                    $eventRepetition->end_repeat = $dateEnd." ".$timeEnd;
                    $eventRepetition->save();

                    break;

                case '2':   // repeatWeekly
                    /*switch($request->get('repeat_week_kind')){
                        case 'repeat_count':
                            // Convert the start date in a format that can be used for strtotime
                                $startDate = implode("-", array_reverse(explode("/",$request->get('startDate'))));
                            // Calculate repeat until day
                                $repeatUntilDate = date('d-m-Y', strtotime($startDate. ' + '.$request->get('how_many_weeks').' weeks'));

                            //dd($repeatUntilDate);
                            $this->saveWeeklyRepeatDates($event, $request->get('repeat_weekly_on_day'),$startDate,$repeatUntilDate, $timeStart, $timeEnd);

                        break;
                        case 'repeat_until':
                        // Convert the start date in a format that can be used for strtotime
                            $startDate = implode("-", array_reverse(explode("/",$request->get('startDate'))));
                        // Calculate repeat until day
                            $repeatUntilDate = implode("-", array_reverse(explode("/",$request->get('repeatUntil'))));

                        //dd($repeatUntilDate);
                        $this->saveWeeklyRepeatDates($event, $request->get('repeat_weekly_on_day'),$startDate,$repeatUntilDate, $timeStart, $timeEnd);
                        break;
                    }*/

                    // Convert the start date in a format that can be used for strtotime
                        $startDate = implode("-", array_reverse(explode("/",$request->get('startDate'))));

                    // Calculate repeat until day
                        $repeatUntilDate = implode("-", array_reverse(explode("/",$request->get('repeat_until'))));

                        $this->saveWeeklyRepeatDates($event, $request->get('repeat_weekly_on_day'),$startDate,$repeatUntilDate, $timeStart, $timeEnd);

                    break;

                case '3':  //repeatMonthly
                    //Second case...
                    break;
            }
    }

    /***************************************************************************/
    /**
     * Check the date and return true if the weekday is the one specified in $dayOfTheWeek. eg. if $dayOfTheWeek = 3, is true if the date is a Wednesday
     * https://stackoverflow.com/questions/2045736/getting-all-dates-for-mondays-and-tuesdays-for-the-next-year
     *
     * @param  \App\Event  $event
     * @param  date  $date
     * @param  int $dayOfTheWeek [1..7]
     * @return none
     */
    function isWeekDay($date, $dayOfTheWeek){
        return date('w', strtotime($date)) === $dayOfTheWeek;
    }

    /***************************************************************************/
    /**
     * Delete all the previous repetitions from the event_repetitions table
     *
     * @param  \App\Event  $event
     * @param  string  $weekDays - $request->get('repeat_weekly_on_day')
     * @param  string $startDate
     * @param  string $repeatUntilDate
     * @param  string  $timeStart
     * @param  string  $timeEnd
     * @return none
     */
    function saveWeeklyRepeatDates($event, $weekDays, $startDate, $repeatUntilDate, $timeStart, $timeEnd){

        $beginPeriod = new DateTime($startDate);
        $endPeriod = new DateTime($repeatUntilDate);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($beginPeriod, $interval, $endPeriod);

        //$event_time_start = date("H:i:s", strtotime($timeStart));
        //$event_time_end = date("H:i:s", strtotime($timeEnd));

        foreach ($period as $day) {  // Iterate for each day of the period
            foreach($weekDays as $weekDayNumber){ // Iterate for every day of the week (1:Monday, 2:Tuesday, 3:Wednesday ...)
                if ($this->isWeekDay($day->format("Y-m-d"), $weekDayNumber)){

                    $eventRepetition = new EventRepetition();
                    $eventRepetition->event_id = $event->id;

                    $eventRepetition->start_repeat = $day->format("Y-m-d ").$timeStart;
                    $eventRepetition->end_repeat = $day->format("Y-m-d ").$timeEnd;
                    $eventRepetition->save();
                }
            }
        }
    }

    /***************************************************************************/
    /**
     * Delete all the previous repetitions from the event_repetitions table
     *
     * @param  $eventId - Event id
     * @return none
     */
    function deletePreviousRepetitions($eventId){
        DB::table('event_repetitions')->where('event_id', $eventId)->delete();
    }

    // **********************************************************************

    /**
     * Send the Misuse mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirect to route
     */
    public function reportMisuse(Request $request){
        $report = array();

        $report['senderEmail'] = "noreply@globalcicalendar.com";
        $report['senderName'] = "Anonymus User";
        $report['subject'] = "Report misuse form";
        $report['emailTo'] = "davide.casiraghi@gmail.com";

        $report['message'] = $request->message;
        $report['event_title'] = $request->event_title;
        $report['event_id'] = $request->event_id;

        switch ($request->reason) {
            case '1':
                $report['reason'] = "Not about Contact Improvisation";
                break;
            case '2':
                $report['reason'] = "Contains wrong informations";
                break;
            case '3':
                $report['reason'] = "It is not translated in english";
                break;
            case '4':
                $report['reason'] = "Other (specify in the message)";
                break;
        }

         //Mail::to($request->user())->send(new ReportMisuse($report));
         Mail::to("davide.casiraghi@gmail.com")->send(new ReportMisuse($report));

         return redirect()->route('events.misuse-thankyou');

    }

    // **********************************************************************

    /**
     * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route)
     *
     * @param  \App\Event  $event
     * @return view
     */
    public function reportMisuseThankyou(){

        return view('emails.report-thankyou');
    }

    // **********************************************************************

    /**
     * Set the Event attributes about repeating before store or update (repeat until field and multiple days)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \App\Event  $event
     */
    public function setEventRepeatFields($request, $event){

        // Set Repeat Until
            $event->repeat_type = $request->get('repeat_type');
            if($request->get('repeat_until')){
                $dateRepeatUntil = implode("-", array_reverse(explode("/",$request->get('repeat_until'))));
                $event->repeat_until = $dateRepeatUntil." 00:00:00";
            }

        // Weekely - Set multiple week days
            if($request->get('repeat_weekly_on_day')){
                $repeat_weekly_on_day = $request->get('repeat_weekly_on_day');
                //dd($repeat_weekly_on_day);
                $i = 0; $len = count($repeat_weekly_on_day); // to put "," to all items except the last
                $event->repeat_weekly_on = "";
                foreach ($repeat_weekly_on_day as $key => $weeek_day) {
                    $event->repeat_weekly_on .= $weeek_day;
                    if ($i != $len - 1)  // not last
                        $event->repeat_weekly_on .= ",";
                    $i++;
                }
            }

        // Monthly

    /* $event->repeat_type = $request->get('repeat_monthly_on');*/

        return $event;
    }

    // **********************************************************************


    public function calculateMonthlySelectOptions(Request $request){
        // https://www.theindychannel.com/calendar

        $monthlySelectOptions = array();

        // same day number - eg. "the 28th day of the month"
            $dateArray = explode("/",$request->day);
            $dayNumber = $dateArray[0];
            switch ($dayNumber) {
                case  1:
                    $ordinalIndicator = "st";
                    break;
                case  2:
                    $ordinalIndicator = "nd";
                    break;
                case  3:
                    $ordinalIndicator = "nd";
                    break;
                default:
                    $ordinalIndicator = "th";
                    break;
            }

            array_push($monthlySelectOptions, "the ".$dayNumber.$ordinalIndicator." day of the month");

        // Same weekday/week of the month - eg. the "1st Monday"

            // Our YYYY-MM-DD date string
                $date = implode("-", array_reverse(explode("/",$request->day)));

            // Convert the date string into a unix timestamp.
                $unixTimestamp = strtotime($date);

            // Get the day of the week using PHP's date function.
                $dayOfWeek = date("l", $unixTimestamp);
                $weekOfTheMonth = $this->weekOfMonth($unixTimestamp);

            array_push($monthlySelectOptions, "the ".$weekOfTheMonth." ".$dayOfWeek." of the month");


        // ?

        // n day before the end of the month - the 4th to last day

        // last



        //$monthlySelectOptions = $request->day;

        return $monthlySelectOptions;
    }

    // get number of week for month
    // https://stackoverflow.com/questions/5853380/php-get-number-of-week-for-month
    function weekOfMonth($when = null) {
        if ($when === null) $when = time();
        $week = strftime('%U', $when); // weeks start on Sunday
        $firstWeekOfMonth = strftime('%U', strtotime(date('Y-m-01', $when)));
        return 1 + ($week < $firstWeekOfMonth ? $week : $week - $firstWeekOfMonth);
    }


}
