<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use App\Event;
use Validator;
use DatePeriod;
use App\Country;
use App\Teacher;
use DateInterval;
use App\Organizer;
use App\EventVenue;
use App\EventCategory;
use App\EventRepetition;
use App\Mail\ReportMisuse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ContactOrganizer;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /***************************************************************************/
    /* Restrict the access to this resource just to logged in users except show view */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'reportMisuse', 'reportMisuseThankyou', 'mailToOrganizer', 'mailToOrganizerSent', 'eventBySlug', 'eventBySlugAndRepetition', 'EventsListByCountry']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // To show just the events created by the the user - If admin or super admin is set to null show all the events
        $authorUserId = ($this->getLoggedAuthorId()) ? $this->getLoggedAuthorId() : null; // if is 0 (super admin or admin) it's setted to null to avoid include it in the query

        $eventCategories = EventCategory::orderBy('name')->pluck('name', 'id');
        $countries = Country::orderBy('name')->pluck('name', 'id');
        $venues = EventVenue::pluck('country_id', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');
        $searchCountry = $request->input('country_id');

        if ($searchKeywords || $searchCategory || $searchCountry) {
            $events = Event::
                // Show only the events owned by the user, if the user is an admin or super admin show all the events
                when(isset($authorUserId), function ($query, $authorUserId) {
                    return $query->where('created_by', $authorUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('category_id', '=', $searchCategory);
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->join('event_venues', 'events.venue_id', '=', 'event_venues.id')->where('event_venues.country_id', '=', $searchCountry);
                })
                ->select('*', 'events.id as id', 'events.slug as slug', 'events.image as image') // To keep in the join the id of the Events table - https://stackoverflow.com/questions/28062308/laravel-eloquent-getting-id-field-of-joined-tables-in-eloquent
                ->paginate(20);

        //dd($events);
        } else {
            $events = Event::latest()
                ->when($authorUserId, function ($query, $authorUserId) {
                    return $query->where('created_by', $authorUserId);
                })->paginate(20);
        }

        return view('events.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('eventCategories', $eventCategories)
            ->with('countries', $countries)
            ->with('venues', $venues)
            ->with('searchKeywords', $searchKeywords)
            ->with('searchCategory', $searchCategory)
            ->with('searchCountry', $searchCountry);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authorUserId = $this->getLoggedAuthorId();

        $eventCategories = EventCategory::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $organizers = Organizer::pluck('name', 'id');
        //$venues = EventVenue::pluck('name', 'id');
        $venues = DB::table('event_venues')
                ->select('id', 'name', 'city')->get();

        $dateTime = [];
        $dateTime['repeatUntil'] = null;

        return view('events.create')
            ->with('eventCategories', $eventCategories)
            ->with('users', $users)
            ->with('teachers', $teachers)
            ->with('organizers', $organizers)
            ->with('venues', $venues)
            ->with('dateTime', $dateTime)
            ->with('authorUserId', $authorUserId);
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form datas
        $validator = $this->eventsValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $event = new Event();
        $this->saveOnDb($request, $event);

        return redirect()->route('events.index')
                        ->with('success', __('messages.event_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @param  $firstRpDates
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, $firstRpDates)
    {
        $category = EventCategory::find($event->category_id);
        $teachers = $event->teachers()->get();
        $organizers = $event->organizers()->get();

        $venue = DB::table('event_venues')
                ->select('id', 'name', 'city', 'address', 'zip_code', 'country_id')
                ->where('id', $event->venue_id)
                ->first();

        $country = DB::table('countries')
                ->select('id', 'name', 'continent_id')
                ->where('id', $venue->country_id)
                ->first();

        $continent = DB::table('continents')
                ->select('id', 'name')
                ->where('id', $country->continent_id)
                ->first();

        // Repetition text to show
        switch ($event->repeat_type) {
                case '1': // noRepeat
                    $repetition_text = null;
                    break;
                case '2': // repeatWeekly
                    $repeatUntil = new DateTime($event->repeat_until);

                    // Get the name of the weekly day when the event repeat, if two days, return like "Thursday and Sunday"
                        $repetitonWeekdayNumbersArray = explode(',', $event->repeat_weekly_on);
                        $repetitonWeekdayNamesArray = [];
                        foreach ($repetitonWeekdayNumbersArray as $key => $repetitonWeekdayNumber) {
                            $repetitonWeekdayNamesArray[] = $this->decodeRepeatWeeklyOn($repetitonWeekdayNumber);
                        }
                        // create from an array a string with all the values divided by " and "
                        $nameOfTheRepetitionWeekDays = implode(' and ', $repetitonWeekdayNamesArray);

                    $repetition_text = 'The event happens every '.$nameOfTheRepetitionWeekDays.' until '.$repeatUntil->format('d/m/Y');
                    break;
                case '3': //repeatMonthly
                    $repeatUntil = new DateTime($event->repeat_until);
                    $repetitionFrequency = $this->decodeOnMonthlyKind($event->on_monthly_kind);
                    $repetition_text = 'The event happens '.$repetitionFrequency.' until '.$repeatUntil->format('d/m/Y');
                    break;
            }

        // True if the repetition start and end on the same day
        $sameDateStartEnd = ((date('Y-m-d', strtotime($firstRpDates->start_repeat))) == (date('Y-m-d', strtotime($firstRpDates->end_repeat)))) ? 1 : 0;

        return view('events.show', compact('event'))
                ->with('category', $category)
                ->with('teachers', $teachers)
                ->with('organizers', $organizers)
                ->with('venue', $venue)
                ->with('country', $country)
                ->with('continent', $continent)
                ->with('datesTimes', $firstRpDates)
                ->with('repetition_text', $repetition_text)
                ->with('sameDateStartEnd', $sameDateStartEnd);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if (Auth::user()->id == $event->created_by || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            $authorUserId = $this->getLoggedAuthorId();

            $eventCategories = EventCategory::pluck('name', 'id');
            $users = User::pluck('name', 'id');
            $teachers = Teacher::pluck('name', 'id');
            $organizers = Organizer::pluck('name', 'id');
            $venues = DB::table('event_venues')
                    ->select('id', 'name', 'address', 'city')->get();

            $eventFirstRepetition = DB::table('event_repetitions')
                    ->select('id', 'start_repeat', 'end_repeat')
                    ->where('event_id', '=', $event->id)
                    ->first();

            $dateTime = [];
            $dateTime['dateStart'] = (isset($eventFirstRepetition->start_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->start_repeat)) : '';
            $dateTime['dateEnd'] = (isset($eventFirstRepetition->end_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->end_repeat)) : '';
            $dateTime['timeStart'] = (isset($eventFirstRepetition->start_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->start_repeat)) : '';
            $dateTime['timeEnd'] = (isset($eventFirstRepetition->end_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->end_repeat)) : '';
            $dateTime['repeatUntil'] = date('d/m/Y', strtotime($event->repeat_until));

            // GET Multiple teachers
            $teachersDatas = $event->teachers;
            $teachersSelected = [];
            foreach ($teachersDatas as $teacherDatas) {
                array_push($teachersSelected, $teacherDatas->id);
            }
            $multiple_teachers = implode(',', $teachersSelected);

            // GET Multiple Organizers
            $organizersDatas = $event->organizers;
            $organizersSelected = [];
            foreach ($organizersDatas as $organizerDatas) {
                array_push($organizersSelected, $organizerDatas->id);
            }
            $multiple_organizers = implode(',', $organizersSelected);

            return view('events.edit', compact('event'))
                        ->with('eventCategories', $eventCategories)
                        ->with('users', $users)
                        ->with('teachers', $teachers)
                        ->with('multiple_teachers', $multiple_teachers)
                        ->with('organizers', $organizers)
                        ->with('multiple_organizers', $multiple_organizers)
                        ->with('venues', $venues)
                        ->with('dateTime', $dateTime)
                        ->with('authorUserId', $authorUserId);
        } else {
            return redirect()->route('home')->with('message', __('auth.not_allowed_to_access'));
        }
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        // Validate form datas
        $validator = $this->eventsValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->saveOnDb($request, $event);

        return redirect()->route('events.index')
                        ->with('success', __('messages.event_updated_successfully'));
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $eventFirstRepetition = DB::table('event_repetitions')
                //->where('active', 0)->delete();
                ->where('event_id', $event->id)
                ->delete();

        $event->delete();

        return redirect()->route('events.index')
                        ->with('success', __('messages.event_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * To save event repetitions for create and update methods.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return void
     */
    public function saveEventRepetitions($request, $event)
    {
        Event::deletePreviousRepetitions($event->id);

        // Saving repetitions - If it's a single event will be stored with just one repetition
        $timeStart = date('H:i:s', strtotime($request->get('time_start')));
        $timeEnd = date('H:i:s', strtotime($request->get('time_end')));
        switch ($request->get('repeat_type')) {
                case '1':  // noRepeat
                    $eventRepetition = new EventRepetition();
                    $eventRepetition->event_id = $event->id;

                    $dateStart = implode('-', array_reverse(explode('/', $request->get('startDate'))));
                    $dateEnd = implode('-', array_reverse(explode('/', $request->get('endDate'))));

                    $eventRepetition->start_repeat = $dateStart.' '.$timeStart;
                    $eventRepetition->end_repeat = $dateEnd.' '.$timeEnd;
                    $eventRepetition->save();

                    break;

                case '2':   // repeatWeekly

                    // Convert the start date in a format that can be used for strtotime
                        $startDate = implode('-', array_reverse(explode('/', $request->get('startDate'))));

                    // Calculate repeat until day
                        $repeatUntilDate = implode('-', array_reverse(explode('/', $request->get('repeat_until'))));
                        $this->saveWeeklyRepeatDates($event, $request->get('repeat_weekly_on_day'), $startDate, $repeatUntilDate, $timeStart, $timeEnd);

                    break;

                case '3':  //repeatMonthly
                    // Same of repeatWeekly
                        $startDate = implode('-', array_reverse(explode('/', $request->get('startDate'))));
                        $repeatUntilDate = implode('-', array_reverse(explode('/', $request->get('repeat_until'))));

                    // Get the array with month repeat details
                        $monthRepeatDatas = explode('|', $request->get('on_monthly_kind'));

                        $this->saveMonthlyRepeatDates($event, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

                    break;
            }
    }

    /***************************************************************************/

    /**
     * Check the date and return true if the weekday is the one specified in $dayOfTheWeek. eg. if $dayOfTheWeek = 3, is true if the date is a Wednesday
     * $dayOfTheWeek: 1|2|3|4|5|6|7 (MONDAY-SUNDAY)
     * https://stackoverflow.com/questions/2045736/getting-all-dates-for-mondays-and-tuesdays-for-the-next-year.
     *
     * @param  \App\Event  $event
     * @param  string $date
     * @param  int $dayOfTheWeek
     * @return void
     */
    public function isWeekDay($date, $dayOfTheWeek)
    {
        // Fix the bug that was avoiding to save Sunday. Date 'w' identify sunday as 0 and not 7.
        if ($dayOfTheWeek == 7) {
            $dayOfTheWeek = 0;
        }

        return date('w', strtotime($date)) == $dayOfTheWeek;
    }

    /***************************************************************************/

    /**
     * Save all the weekly repetitions in the event_repetitions table.
     * $dateStart and $dateEnd are in the format Y-m-d
     * $timeStart and $timeEnd are in the format H:i:s.
     * $weekDays - $request->get('repeat_weekly_on_day').
     * @param  \App\Event  $event
     * @param  string  $weekDays
     * @param  string  $startDate
     * @param  string  $repeatUntilDate
     * @param  string  $timeStart
     * @param  string  $timeEnd
     * @return void
     */
    public function saveWeeklyRepeatDates($event, $weekDays, $startDate, $repeatUntilDate, $timeStart, $timeEnd)
    {
        $beginPeriod = new DateTime($startDate);
        $endPeriod = new DateTime($repeatUntilDate);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($beginPeriod, $interval, $endPeriod);

        foreach ($period as $day) {  // Iterate for each day of the period
            foreach ($weekDays as $weekDayNumber) { // Iterate for every day of the week (1:Monday, 2:Tuesday, 3:Wednesday ...)
                if ($this->isWeekDay($day->format('Y-m-d'), $weekDayNumber)) {
                    $this->saveEventRepetitionOnDB($event->id, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);
                }
            }
        }
    }

    /***************************************************************************/

    /**
     * Save all the weekly repetitions inthe event_repetitions table
     * useful: http://thisinterestsme.com/php-get-first-monday-of-month/.
     *
     * @param  \App\Event  $event
     * @param  array   $monthRepeatDatas - explode of $request->get('on_monthly_kind')
     *                      0|28 the 28th day of the month
     *                      1|2|2 the 2nd Tuesday of the month
     *                      2|17 the 18th to last day of the month
     *                      3|1|3 the 2nd to last Wednesday of the month
     * @param  string  $startDate (Y-m-d)
     * @param  string  $repeatUntilDate (Y-m-d)
     * @param  string  $timeStart (H:i:s)
     * @param  string  $timeEnd (H:i:s)
     * @return void
     */
    public function saveMonthlyRepeatDates($event, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd)
    {
        $start = $month = strtotime($startDate);
        $end = strtotime($repeatUntilDate);

        $numberOfTheWeekArray = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth'];
        $weekdayArray = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        switch ($monthRepeatDatas[0]) {
            case '0':  // Same day number - eg. "the 28th day of the month"
                while ($month < $end) {
                    $day = date('Y-m-d', $month);
                    $this->saveEventRepetitionOnDB($event->id, $day, $day, $timeStart, $timeEnd);
                    $month = strtotime('+1 month', $month);
                }
                break;
            case '1':  // Same weekday/week of the month - eg. the "1st Monday"
                $numberOfTheWeek = $numberOfTheWeekArray[$monthRepeatDatas[1] - 1]; //eg. first | second | third | fourth | fifth
                $weekday = $weekdayArray[$monthRepeatDatas[2] - 1]; // eg. monday | tuesday | wednesday

                while ($month < $end) {
                    $monthString = date('Y-m', $month);  //eg. 2015-12

                    // The day to pick
                        //dd($numberOfTheWeek." ".$weekday." ".$monthString);
                    $day = date('Y-m-d', strtotime($numberOfTheWeek.' '.$weekday.' '.$monthString));  // get the first weekday of a month eg. strtotime("first wednesday 2015-12")
                    $this->saveEventRepetitionOnDB($event->id, $day, $day, $timeStart, $timeEnd);
                    $month = strtotime('+1 month', $month);
                }
                break;
            case '2':  // Same day of the month (from the end) - the 3rd to last day (0 if last day, 1 if 2nd to last day, 2 if 3rd to last day)
                while ($month < $end) {
                    $monthString = date('Y-m', $month);  //eg. 2015-12
                    $day = date('Y-m-d', strtotime('last day of '.$monthString));  // get the last day of a month eg. strtotime("last day of 2015-12")
                    $this->saveEventRepetitionOnDB($event->id, $day, $day, $timeStart, $timeEnd);
                    $month = strtotime('+1 month', $month);
                }
                break;
            case '3':  // Same weekday/week of the month (from the end) - the last Friday - (0 if last Friday, 1 if the 2nd to last Friday, 2 if the 3nd to last Friday)
                $numberOfTheWeekFromTheEnd = $monthRepeatDatas[1]; //eg. 0(last) | 1 | 2 | 3 | 4
                $weekday = $weekdayArray[$monthRepeatDatas[2] - 1]; // eg. monday | tuesday | wednesday
                while ($month < $end) {
                    $monthString = date('Y-m', $month);  //eg. 2015-12
                    $timestamp = strtotime(date('Y-m-d', strtotime('last '.$weekday.' of '.$monthString))); // get the last weekday of a month eg. strtotime("last wednesday 2015-12")
                    //dd(date("Y-m-d", strtotime("last ".$weekday." of ".$monthString)));
                    switch ($numberOfTheWeekFromTheEnd) {
                        case '0':
                            $day = date('Y-m-d', $timestamp);
                            break;
                        case '1':
                            $day = date('Y-m-d', strtotime('-1 week', $timestamp));
                            break;
                        default:
                            $day = date('Y-m-d', strtotime('-'.$numberOfTheWeekFromTheEnd.' weeks', $timestamp));
                            break;
                    }

                    $this->saveEventRepetitionOnDB($event->id, $day, $day, $timeStart, $timeEnd);
                    $month = strtotime('+1 month', $month);
                }
                break;
        }
    }

    /***************************************************************************/

    /**
     * Save event repetition in the DB.
     * $dateStart and $dateEnd are in the format Y-m-d
     * $timeStart and $timeEnd are in the format H:i:s.
     * @param  int $eventId
     * @param  string $dateStart
     * @param  string $dateEnd
     * @param  string $timeStart
     * @param  string $timeEnd
     * @return void
     */
    public function saveEventRepetitionOnDB($eventId, $dateStart, $dateEnd, $timeStart, $timeEnd)
    {
        $eventRepetition = new EventRepetition();
        $eventRepetition->event_id = $eventId;

        $eventRepetition->start_repeat = $dateStart.' '.$timeStart;
        $eventRepetition->end_repeat = $dateEnd.' '.$timeEnd;
        $eventRepetition->save();
    }

    /***************************************************************************/

    /**
     * Send the Misuse mail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reportMisuse(Request $request)
    {
        $report = [];

        $report['senderEmail'] = 'noreply@globalcicalendar.com';
        $report['senderName'] = 'Anonymus User';
        $report['subject'] = 'Report misuse form';
        $report['adminEmail'] = env('ADMIN_MAIL');
        $report['creatorEmail'] = $this->getCreatorEmail($request->created_by);

        $report['message'] = $request->message;
        $report['event_title'] = $request->event_title;
        $report['event_id'] = $request->event_id;

        switch ($request->reason) {
            case '1':
                $report['reason'] = 'Not about Contact Improvisation';
                break;
            case '2':
                $report['reason'] = 'Contains wrong informations';
                break;
            case '3':
                $report['reason'] = 'It is not translated in english';
                break;
            case '4':
                $report['reason'] = 'Other (specify in the message)';
                break;
        }

        //Mail::to($request->user())->send(new ReportMisuse($report));
        Mail::to('davide.casiraghi@gmail.com')->send(new ReportMisuse($report));

        return redirect()->route('events.misuse-thankyou');
    }

    /***************************************************************************/

    /**
     * Send the mail to the Organizer (from the event modal in the event show view).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mailToOrganizer(Request $request)
    {
        $message = [];
        $message['senderEmail'] = $request->user_email;
        $message['senderName'] = $request->user_name;
        $message['subject'] = 'Request from the Global CI Calendar';
        //$message['emailTo'] = $organizersEmails;

        $message['message'] = $request->message;
        $message['event_title'] = $request->event_title;
        $message['event_id'] = $request->event_id;

        /*
        $eventOrganizers = Event::find($request->event_id)->organizers;
        foreach ($eventOrganizers as $eventOrganizer) {
            Mail::to($eventOrganizer->email)->send(new ContactOrganizer($message));
        }*/
        Mail::to($request->contact_email)->send(new ContactOrganizer($message));

        return redirect()->route('events.organizer-sent');
    }

    /***************************************************************************/

    /**
     * Display the thank you view after the mail to the organizer is sent (called by /mailToOrganizer/sent route).
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function mailToOrganizerSent()
    {
        return view('emails.contact.organizer-sent');
    }

    /***************************************************************************/

    /**
     * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route).
     * @return \Illuminate\Http\Response
     */
    public function reportMisuseThankyou()
    {
        return view('emails.report-thankyou');
    }

    /***************************************************************************/

    /**
     * Set the Event attributes about repeating before store or update (repeat until field and multiple days).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \App\Event  $event
     */
    public function setEventRepeatFields($request, $event)
    {

        // Set Repeat Until
        $event->repeat_type = $request->get('repeat_type');
        if ($request->get('repeat_until')) {
            $dateRepeatUntil = implode('-', array_reverse(explode('/', $request->get('repeat_until'))));
            $event->repeat_until = $dateRepeatUntil.' 00:00:00';
        }

        // Weekely - Set multiple week days
        if ($request->get('repeat_weekly_on_day')) {
            $repeat_weekly_on_day = $request->get('repeat_weekly_on_day');
            //dd($repeat_weekly_on_day);
            $i = 0;
            $len = count($repeat_weekly_on_day); // to put "," to all items except the last
            $event->repeat_weekly_on = '';
            foreach ($repeat_weekly_on_day as $key => $weeek_day) {
                $event->repeat_weekly_on .= $weeek_day;
                if ($i != $len - 1) {  // not last
                    $event->repeat_weekly_on .= ',';
                }
                $i++;
            }
        }

        // Monthly

        /* $event->repeat_type = $request->get('repeat_monthly_on');*/

        return $event;
    }

    /***************************************************************************/

    /**
     * Return the HTML of the monthly select dropdown - inspired by - https://www.theindychannel.com/calendar
     * - Used by the AJAX in the event repeat view -
     * - The HTML contain a <select></select> with four <options></options>.
     *
     * @param  \Illuminate\Http\Request  $request  - Just the day
     * @return string
     */
    public function calculateMonthlySelectOptions(Request $request)
    {
        $monthlySelectOptions = [];
        $date = implode('-', array_reverse(explode('/', $request->day)));  // Our YYYY-MM-DD date string
        $unixTimestamp = strtotime($date);  // Convert the date string into a unix timestamp.
        $dayOfWeekString = date('l', $unixTimestamp); // Monday | Tuesday | Wednesday | ..

        // Same day number - eg. "the 28th day of the month"
        $dateArray = explode('/', $request->day);
        $dayNumber = ltrim($dateArray[0], '0'); // remove the 0 in front of a day number eg. 02/10/2018
        $ordinalIndicator = $this->getOrdinalIndicator($dayNumber);

        array_push($monthlySelectOptions, [
                'value' => '0|'.$dayNumber,
                'text' => 'the '.$dayNumber.$ordinalIndicator.' day of the month',
            ]);

        // Same weekday/week of the month - eg. the "1st Monday" 1|1|1 (first week, monday)
            $dayOfWeekValue = date('N', $unixTimestamp); // 1 (for Monday) through 7 (for Sunday)
            $weekOfTheMonth = $this->weekdayNumberOfMonth($date, $dayOfWeekValue); // 1 | 2 | 3 | 4 | 5
            $ordinalIndicator = $this->getOrdinalIndicator($weekOfTheMonth); //st, nd, rd, th

            array_push($monthlySelectOptions, [
                'value' => '1|'.$weekOfTheMonth.'|'.$dayOfWeekValue,
                'text' => 'the '.$weekOfTheMonth.$ordinalIndicator.' '.$dayOfWeekString.' of the month',
            ]);

        // Same day of the month (from the end) - the 3rd to last day (0 if last day, 1 if 2nd to last day, , 2 if 3rd to last day)
            $dayOfMonthFromTheEnd = $this->dayOfMonthFromTheEnd($unixTimestamp); // 1 | 2 | 3 | 4 | 5
            $ordinalIndicator = $this->getOrdinalIndicator($dayOfMonthFromTheEnd);

        if ($dayOfMonthFromTheEnd == 1) {
            $dayText = 'last';
            $dayValue = 0;
        } else {
            $dayText = $dayOfMonthFromTheEnd.$ordinalIndicator.' to last';
            $dayValue = $dayOfMonthFromTheEnd - 1;
        }

        array_push($monthlySelectOptions, [
            'value' => '2|'.$dayValue,
            'text' => 'the '.$dayText.' day of the month',
        ]);

        // Same weekday/week of the month (from the end) - the last Friday - (0 if last Friday, 1 if the 2nd to last Friday, 2 if the 3nd to last Friday)

        // Get the date parameters
                $weekOfMonthFromTheEnd = $this->weekOfMonthFromTheEnd($unixTimestamp); // 1 | 2 | 3 | 4 | 5
                $ordinalIndicator = $this->getOrdinalIndicator($weekOfMonthFromTheEnd);

        if ($weekOfMonthFromTheEnd == 1) {
            $weekText = 'last ';
            $weekValue = 0;
        } else {
            $weekText = $weekOfMonthFromTheEnd.$ordinalIndicator.' to last ';
            $weekValue = $weekOfMonthFromTheEnd - 1;
        }

        array_push($monthlySelectOptions, [
                'value' => '3|'.$weekValue.'|'.$dayOfWeekValue,
                'text' => 'the '.$weekText.$dayOfWeekString.' of the month',
            ]);

        // GENERATE the HTML to return
        $onMonthlyKindSelect = "<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='Select repeat monthly kind'>";
        foreach ($monthlySelectOptions as $key => $monthlySelectOption) {
            $onMonthlyKindSelect .= "<option value='".$monthlySelectOption['value']."'>".$monthlySelectOption['text'].'</option>';
        }
        $onMonthlyKindSelect .= '</select>';

        return $onMonthlyKindSelect;
    }

    /***************************************************************************/

    /**
     * GET number of the specified weekday in this month (1 for the first).
     * $dateTimestamp - unix timestramp of the date specified
     * $dayOfWeekValue -  1 (for Monday) through 7 (for Sunday)
     * Return the number of the week in the month of the weekday specified.
     * @param  string $dateTimestamp
     * @param  string $dayOfWeekValue
     * @return int
     */
    public function weekdayNumberOfMonth($dateTimestamp, $dayOfWeekValue)
    {
        $cut = substr($dateTimestamp, 0, 8);
        $daylen = 86400;
        $timestamp = strtotime($dateTimestamp);
        $first = strtotime($cut.'01');
        $elapsed = (($timestamp - $first) / $daylen) + 1;
        $i = 1;
        $weeks = 0;
        for ($i == 1; $i <= $elapsed; $i++) {
            $dayfind = $cut.(strlen($i) < 2 ? '0'.$i : $i);
            $daytimestamp = strtotime($dayfind);
            $day = strtolower(date('N', $daytimestamp));
            if ($day == strtolower($dayOfWeekValue)) {
                $weeks++;
            }
        }
        if ($weeks == 0) {
            $weeks++;
        }

        return $weeks;
    }

    /***************************************************************************/

    /**
     * GET number of week from the end of the month - https://stackoverflow.com/questions/5853380/php-get-number-of-week-for-month
     * Week of the month = Week of the year - Week of the year of first day of month + 1.
     * Return the number of the week in the month of the day specified
     * $when - unix timestramp of the date specified.
     *
     * @param  string $when
     * @return int
     */
    public function weekOfMonthFromTheEnd($when = null)
    {
        $numberOfDayOfTheMonth = strftime('%e', $when); // Day of the month 1-31
        $lastDayOfMonth = strftime('%e', strtotime(date('Y-m-t', $when))); // the last day of the month of the specified date
        $dayDifference = $lastDayOfMonth - $numberOfDayOfTheMonth;

        switch (true) {
            case $dayDifference < 7:
                $weekFromTheEnd = 1;
                break;

            case $dayDifference < 14:
                $weekFromTheEnd = 2;
                break;

            case $dayDifference < 21:
                $weekFromTheEnd = 3;
                break;

            case $dayDifference < 28:
                $weekFromTheEnd = 4;
                break;

            default:
                $weekFromTheEnd = 5;
                break;
        }

        return $weekFromTheEnd;
    }

    /***************************************************************************/

    /**
     * GET number of day from the end of the month.
     * $when - unix timestramp of the date specified
     * Return the number of day of the month from end.
     *
     * @param  string $when
     * @return int
     */
    public function dayOfMonthFromTheEnd($when = null)
    {
        $numberOfDayOfTheMonth = strftime('%e', $when); // Day of the month 1-31
        $lastDayOfMonth = strftime('%e', strtotime(date('Y-m-t', $when))); // the last day of the month of the specified date
        $dayDifference = $lastDayOfMonth - $numberOfDayOfTheMonth;

        return $dayDifference;
    }

    /***************************************************************************/

    /**
     * GET the ordinal indicator - for the day of the month.
     * Return the ordinal indicator (st, nd, rd, th).
     * @param  int $number
     * @return string
     */
    public function getOrdinalIndicator($number)
    {
        switch ($number) {
            case  1:
                $ret = 'st';
                break;
            case  2:
                $ret = 'nd';
                break;
            case  3:
                $ret = 'rd';
                break;
            default:
                $ret = 'th';
                break;
        }

        return $ret;
    }

    /***************************************************************************/

    /**
     * Decode the event repeat_weekly_on field - used in event.show.
     * Return a string like "Monday".
     *
     * @param  string $repeatWeeklyOn
     * @return string
     */
    public function decodeRepeatWeeklyOn($repeatWeeklyOn)
    {
        $weekdayArray = ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $ret = $weekdayArray[$repeatWeeklyOn];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Decode the event on_monthly_kind field - used in event.show.
     * Return a string like "the 4th to last Thursday of the month".
     *
     * @param  string $onMonthlyKindCode
     * @return string
     */
    public function decodeOnMonthlyKind($onMonthlyKindCode)
    {
        $onMonthlyKindCodeArray = explode('|', $onMonthlyKindCode);
        $weekDays = ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        //dd($onMonthlyKindCodeArray);
        switch ($onMonthlyKindCodeArray[0]) {
            case '0':  // 0|7 eg. the 7th day of the month
                $dayNumber = $onMonthlyKindCodeArray[1];
                $ordinalIndicator = $this->getOrdinalIndicator($dayNumber);

                $dayNumberOrdinal = $dayNumber.$ordinalIndicator;
                $format = 'the %s day of the month';
                $ret = sprintf($format, $dayNumberOrdinal);
                break;
            case '1':  // 1|2|4 eg. the 2nd Thursday of the month
                $dayNumber = $onMonthlyKindCodeArray[1];
                $ordinalIndicator = $this->getOrdinalIndicator($dayNumber);

                $dayNumberOrdinal = $dayNumber.$ordinalIndicator;
                $weekDay = $weekDays[$onMonthlyKindCodeArray[2]]; // Monday, Tuesday, Wednesday
                $format = 'the %s %s of the month';
                $ret = sprintf($format, $dayNumberOrdinal, $weekDay);
                break;
            case '2': // 2|20 eg. the 21th to last day of the month
                $dayNumber = $onMonthlyKindCodeArray[1] + 1;
                $ordinalIndicator = $this->getOrdinalIndicator($dayNumber);

                $dayNumberOrdinal = $dayNumber.$ordinalIndicator;
                $format = 'the %s to last day of the month';
                $ret = sprintf($format, $dayNumberOrdinal);
                break;
            case '3': // 3|3|4 eg. the 4th to last Thursday of the month
                $dayNumber = $onMonthlyKindCodeArray[1] + 1;
                $ordinalIndicator = $this->getOrdinalIndicator($dayNumber);

                $dayNumberOrdinal = $dayNumber.$ordinalIndicator;
                $weekDay = $weekDays[$onMonthlyKindCodeArray[2]]; // Monday, Tuesday, Wednesday
                $format = 'the %s to last %s of the month';
                $ret = sprintf($format, $dayNumberOrdinal, $weekDay);
                break;
        }

        return $ret;
    }

    // **********************************************************************

    /**
     * Save/Update the record on DB.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Event $event
     * @return string $ret - the ordinal indicator (st, nd, rd, th)
     */
    public function saveOnDb($request, $event)
    {
        $countries = Country::getCountries();
        $teachers = Teacher::pluck('name', 'id');

        $venue = DB::table('event_venues')
                ->select('event_venues.id AS venue_id', 'event_venues.name AS venue_name', 'event_venues.country_id AS country_id', 'event_venues.continent_id', 'event_venues.city')
                ->where('event_venues.id', '=', $request->get('venue_id'))
                ->first();

        $event->title = $request->get('title');
        //$event->description = $request->get('description');
        $event->description = clean($request->get('description'));
        $event->created_by = \Auth::user()->id;
        if (! $event->slug) {
            $event->slug = Str::slug($event->title, '-').'-'.rand(100000, 1000000);
        }
        $event->category_id = $request->get('category_id');
        $event->venue_id = $request->get('venue_id');
        $event->image = $request->get('image');
        $event->contact_email = $request->get('contact_email');
        $event->website_event_link = $request->get('website_event_link');
        $event->facebook_event_link = $request->get('facebook_event_link');
        $event->status = $request->get('status');
        $event->on_monthly_kind = $request->get('on_monthly_kind');

        // Event teaser image upload
        //dd($request->file('image'));
        if ($request->file('image')) {
            $imageFile = $request->file('image');
            $imageName = time().'.'.'jpg';  //$imageName = $teaserImageFile->hashName();
            $imageSubdir = 'events_teaser';
            $imageWidth = '968';
            $thumbWidth = '310';

            $this->uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);
            $event->image = $imageName;
        } else {
            $event->image = $request->get('image');
        }

        // Support columns for homepage search (we need this to show events in HP with less use of resources)
        $event->sc_country_id = $venue->country_id;
        $event->sc_country_name = $countries[$venue->country_id];
        $event->sc_city_name = $venue->city;
        $event->sc_venue_name = $venue->venue_name;
        $event->sc_teachers_id = json_encode(explode(',', $request->get('multiple_teachers')));
        $event->sc_continent_id = $venue->continent_id;

        // Multiple teachers - populate support column field
        if ($request->get('multiple_teachers')) {
            $multiple_teachers = explode(',', $request->get('multiple_teachers'));
            $i = 0;
            $len = count($multiple_teachers); // to put "," to all items except the last
            $event->sc_teachers_names = '';
            foreach ($multiple_teachers as $key => $teacher_id) {
                $event->sc_teachers_names .= $teachers[$teacher_id];

                if ($i != $len - 1) {  // not last
                    $event->sc_teachers_names .= ', ';
                }
                $i++;
            }
        } else {
            $event->sc_teachers_names = '';
        }

        // Set the Event attributes about repeating (repeat until field and multiple days)
        $event = $this->setEventRepeatFields($request, $event);

        // Save event and repetitions
        $event->save();
        $this->saveEventRepetitions($request, $event);

        // Update multi relationships with teachers and organizers tables.
        if ($request->get('multiple_teachers')) {
            $multiple_teachers = explode(',', $request->get('multiple_teachers'));
            $event->teachers()->sync($multiple_teachers);
        } else {
            $event->teachers()->sync([]);
        }
        if ($request->get('multiple_organizers')) {
            $multiple_organizers = explode(',', $request->get('multiple_organizers'));
            $event->organizers()->sync($multiple_organizers);
        } else {
            $event->organizers()->sync([]);
        }
    }

    /***********************************************************************/

    /**
     * Get creator email.
     *
     * @param  int $created_by
     * @return \App\User
     */
    public function getCreatorEmail($created_by)
    {
        $creatorEmail = DB::table('users')  // Used to send the Report misuse (not in english)
                ->select('email')
                ->where('id', $created_by)
                ->first();

        $ret = $creatorEmail->email;

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the event by SLUG. (eg. http://websitename.com/event/xxxx).
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function eventBySlug($slug)
    {
        $event = Event::where('slug', $slug)->first();

        $firstRpDates = Event::getFirstEventRpDatesByEventId($event->id);

        //dd($event);
        return $this->show($event, $firstRpDates);
    }

    /***************************************************************************/

    /**
     * Return the event by SLUG. (eg. http://websitename.com/event/xxxx/300).
     * @param  string $slug
     * @param  int $repetitionId
     * @return \Illuminate\Http\Response
     */
    public function eventBySlugAndRepetition($slug, $repetitionId)
    {
        $event = Event::where('slug', $slug)->first();
        $firstRpDates = Event::getFirstEventRpDatesByRepetitionId($repetitionId);

        /*$firstRpDates = DB::table('event_repetitions')
                            ->select('start_repeat','end_repeat')
                            ->where('id',$repetitionId)
                            ->first();*/

        // If not found get the first repetion of the event in the future.
        if (! $firstRpDates) {
            $firstRpDates = Event::getFirstEventRpDatesByEventId($event->id);
        }

        return $this->show($event, $firstRpDates);
    }

    /***************************************************************************/

    /**
     * Return the Event validator with all the defined constraint.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function eventsValidator($request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'venue_id' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'repeat_until' => Rule::requiredIf($request->repeat_type > 1),
            'repeat_weekly_on_day' => Rule::requiredIf($request->repeat_type == 2),
            'on_monthly_kind' => Rule::requiredIf($request->repeat_type == 3),
            'contact_email' => 'nullable|email',
            'facebook_event_link' => 'nullable|url',
            'website_event_link' => 'nullable|url',
            // 'image' => 'nullable|image|mimes:jpeg,jpg,png|max:3000', // BUG create problems to validate on edit. Fix this after the rollout
        ];
        if ($request->hasFile('image')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,jpg,png|max:5000';
        }

        $messages = [
            'repeat_weekly_on_day[].required' => 'Please specify which day of the week is repeting the event.',
            'on_monthly_kind.required' => 'Please specify the kind of monthly repetion',
            'endDate.same' => 'If the event is repetitive the start date and end date must match',
            'facebook_event_link.url' => 'The facebook link is invalid. It should start with https://',
            'website_event_link.url' => 'The website link is invalid. It should start with https://',
            'image.max' => 'The maximum image size is 5MB. If you need to resize it you can use: www.simpleimageresizer.com',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // End date and start date must match if the event is repetitive
        $validator->sometimes('endDate', 'same:startDate', function ($input) {
            return $input->repeat_type > 1;
        });

        return $validator;
    }
}
