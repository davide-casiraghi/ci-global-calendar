<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\EventRepetition;
use App\Teacher;
use App\Organizer;
use App\EventVenue;
use App\Country;

use Illuminate\Support\Facades\DB;
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

        if ($searchKeywords||$searchCategory||$searchCountry){
            $events = DB::table('events')
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
            $events = Event::latest()->paginate(20);


        return view('events.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('eventCategories',$eventCategories)->with('countries', $countries)->with('venues', $venues)->with('searchKeywords',$searchKeywords)->with('searchCategory',$searchCategory)->with('searchCountry',$searchCountry);
    }

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

        //return view('events.create');
        return view('events.create')->with('eventCategories', $eventCategories)->with('teachers', $teachers)->with('organizers', $organizers)->with('venues', $venues);
    }

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
        $event->facebook_link = $request->get('facebook_link');
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
                foreach ($multiple_teachers as $key => $teacher_id) {
                    $event->sc_teachers_names .= $teachers[$teacher_id];
                    if ($key === key($multiple_teachers))
                        $event->sc_teachers_names .= ", ";
                }
            }

            $event->save();


            switch($request->get('repeatControl')){
                case 'noRepeat':
                    $eventRepetition = new EventRepetition();
                    $eventRepetition->event_id = $event->id;

                    $eventRepetition->start_repeat = "2017-06-17 08:00:00";
                    $eventRepetition->end_repeat = "2017-06-18 17:00:00";
                    $eventRepetition->save();

                    break;

                case 'repeatWeekly':
                    switch($request->get('repeat_week_kind')){
                        case 'repeat_count':
                            // Convert the start date in a format that can be used for strtotime
                                $startDate = implode("-", array_reverse(explode("/",$request->get('startDate'))));
                            // Calculate repeat until day
                                $repeatUntilDate = date('d-m-Y', strtotime($startDate. ' + '.$request->get('how_many_weeks').' weeks'));

                            //dd($repeatUntilDate);
                            $this->saveWeeklyRepeatDates($event, $request->get('repeat_weekly_by_day'),$startDate,$repeatUntilDate);

                        break;
                        case 'repeat_until':
                            //
                        break;
                    }

                    break;

                case 'repeatMonthly':
                    //Second case...
                    break;
            }


        // Update multi relationships with teachers and organizers tables.
            //$event->teachers()->sync([1, 2]);
            //dd($request->get('multiple_teachers'));

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event){
        return view('events.show',compact('event'));
    }

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
                ->select('id','name','city')->get();
                //dd($venues);
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

            //dump($event);

        return view('events.edit',compact('event'))->with('eventCategories', $eventCategories)->with('teachers', $teachers)->with('multiple_teachers', $multiple_teachers)->with('organizers', $organizers)->with('multiple_organizers', $multiple_organizers)->with('venues', $venues);
    }

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
        $event->facebook_link = $request->get('facebook_link');
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

        $event->save();


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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event){
        $event->delete();
        return redirect()->route('events.index')
                        ->with('success','Event deleted successfully');
    }


    /***************************************************************************

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */

     // https://stackoverflow.com/questions/2045736/getting-all-dates-for-mondays-and-tuesdays-for-the-next-year
     // date('w') returns a string numeral as follows:
     //   '0' Sunday
     //   '1' Monday
     //   '2' Tuesday
     //   '3' Wednesday
     //   '4' Thursday
     //   '5' Friday
     //   '6' Saturday

    function isWeekDay($date, $dayOfTheWeek){
        return date('w', strtotime($date)) === $dayOfTheWeek;
    }

    /***************************************************************************

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return array        array with the dates
     */
    function saveWeeklyRepeatDates($event, $weekDays, $startDate, $repeatUntilDate){

        $beginPeriod = new DateTime($startDate);
        $endPeriod = new DateTime($repeatUntilDate);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($beginPeriod, $interval, $endPeriod);

        foreach ($period as $day) {  // Iterate for each day of the period
            foreach($weekDays as $weekDayNumber){ // Iterate for every day of the week (1:Monday, 2:Tuesday, 3:Wednesday ...)
                if ($this->isWeekDay($day->format("Y-m-d"), $weekDayNumber)){

                    $eventRepetition = new EventRepetition();
                    $eventRepetition->event_id = $event->id;

                    $eventRepetition->start_repeat = $day->format("Y-m-d H:i:s");
                    $eventRepetition->end_repeat = $day->format("Y-m-d H:i:s");
                    $eventRepetition->save();
                    //dump($eventRepetition->start_repeat);
                    //dump($eventRepetition->end_repeat);

                    //$eventRepetition->end_repeat = date('d-m-Y', strtotime($eventRepetition->start_repeat. ' + 1 day'));
                    //$eventRepetition->save();
                }
            }
        }
        //dd("ciao");

    }

}
