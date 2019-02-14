<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\Teacher;
use App\Organizer;
use App\EventVenue;
use App\Continent;
use App\Country;
use App\BackgroundImage;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Carbon\Carbon;

class EventSearchController extends Controller
{
    // **********************************************************************     
    /**
     * Display the event search results in Global Calendar Homepage
     * @param  \Illuminate\Http\Request  $request 
     * @return view
     */
    public function index(Request $request){
        /*$eventCategories = EventCategory::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $venues = EventVenue::pluck('name', 'id');*/
        
        
        $minutes = 15; // Set the duration time of the cache
        
        $backgroundImages = BackgroundImage::all();

        $eventCategories = Cache::remember('categories', $minutes, function () {
            return EventCategory::orderBy('name')->pluck('name', 'id');
        });
            
        // Get the countries with active events
        $countries = Cache::remember('events_countries', $minutes, function () {
            
            date_default_timezone_set('Europe/Rome');
            $searchStartDate = date('Y-m-d', time());
            $lastestEventsRepetitionsQuery = $this->getLastestEventsRepetitionsQuery($searchStartDate, null);
            
            return DB::table('countries')
                ->join('event_venues', 'countries.id', '=', 'event_venues.country_id')
                ->join('events', 'event_venues.id', '=', 'events.venue_id')
                ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) use ($searchStartDate) {
                        $join->on('events.id', '=', 'event_repetitions.event_id');
                    })
                ->orderBy('countries.name')
                ->pluck('countries.name', 'countries.id');
        });

        /*$countries = DB::table('countries')
                ->join('event_venues', 'countries.id', '=', 'event_venues.country_id')
                ->join('events', 'event_venues.id', '=', 'events.venue_id')
                ->pluck('countries.name', 'countries.id');*/


        $continents = Cache::rememberForever('continents', function () {
            return Continent::orderBy('name')->pluck('name', 'id');
        });

        $venues = Cache::remember('venues', $minutes, function () {
            return EventVenue::pluck('name', 'id');
        });

        $teachers = Cache::remember('teachers', $minutes, function () {
            return Teacher::orderBy('name')->pluck('name', 'id');
        });

        // Get selected attributes from the search form
            $searchKeywords = $request->input('keywords');
            $searchCategory = $request->input('category_id');
            $searchCountry = $request->input('country_id');
            $searchContinent = $request->input('continent_id');
            $searchTeacher = $request->input('teacher_id');
            $searchVenue = $request->input('venue_name');

            if($request->input('startDate')){
                list($tid,$tim,$tiy) = explode("/",$request->input('startDate'));
                $searchStartDate = "$tiy-$tim-$tid";
            }
            else{
                // If no start date selected the search start from today's date
                date_default_timezone_set('Europe/Rome');
                $searchStartDate = date('Y-m-d', time());
            }
            
            if($request->input('endDate')){
                list($tid,$tim,$tiy) = explode("/",$request->input('endDate'));
                $searchEndDate = "$tiy-$tim-$tid";
            }
            else{
                $searchEndDate = null;
            }
        
        // Sub-Query Joins - https://laravel.com/docs/5.7/queries                        
        $lastestEventsRepetitionsQuery = $this->getLastestEventsRepetitionsQuery($searchStartDate, $searchEndDate);
                                
        // Retrieve the events that correspond to the selected filters
        if ($searchKeywords||$searchCategory||$searchCountry||$searchContinent||$searchTeacher||$searchVenue||$searchStartDate||$searchEndDate){
            //DB::enableQueryLog();
                $events = Event::
                    when($searchKeywords, function ($query, $searchKeywords) {
                        return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%' . $searchKeywords . '%');
                    })
                    ->when($searchCategory, function ($query, $searchCategory) {
                        return $query->where('category_id', '=', $searchCategory);
                    })
                    ->when($searchTeacher, function ($query, $searchTeacher) {
                        return $query->whereRaw('json_contains(sc_teachers_id, \'["' . $searchTeacher . '"]\')');
                    })
                    ->when($searchCountry, function ($query, $searchCountry) {
                        return $query->where('sc_country_id', '=', $searchCountry);
                    })
                    ->when($searchContinent, function ($query, $searchContinent) {
                        return $query->where('sc_continent_id', '=', $searchContinent);
                    })
                    ->when($searchVenue, function ($query, $searchVenue) {
                        return $query->where('title', $searchVenue)->orWhere('sc_venue_name', 'like', '%' . $searchVenue . '%');
                    })
                    ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) use ($searchStartDate,$searchEndDate) {
                        $join->on('events.id', '=', 'event_repetitions.event_id');
                    })
                    ->orderBy('event_repetitions.start_repeat', 'asc')
                    ->paginate(20);
                    //dd(DB::getQueryLog());
        }
        // If no filter selected retrieve all the events
        else{
                $events = Event::
                 where('event_repetitions.start_repeat', '>=',$searchStartDate)
                ->joinSub($lastestEventsRepetitions, 'event_repetitions', function ($join) {
                    $join->on('events.id', '=', 'event_repetitions.event_id');
                })
                ->orderBy('event_repetitions.start_repeat', 'asc')
                ->paginate(20);

                // It works, but I don't use it now to develop
                /*$minutes = 30;
                $events = Cache::remember('all_events', $minutes, function () {
                    return DB::table('events')->latest()->paginate(20);
                });*/
        }

        Carbon::setLocale('ru');
        
        return view('eventSearch.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('eventCategories',$eventCategories)
            ->with('continents', $continents)
            ->with('countries', $countries)
            ->with('venues', $venues)
            ->with('teachers', $teachers)
            ->with('searchKeywords',$searchKeywords)
            ->with('searchCategory',$searchCategory)
            ->with('searchCountry',$searchCountry)
            ->with('searchContinent',$searchContinent)
            ->with('searchTeacher',$searchTeacher)
            ->with('searchVenue',$searchVenue)
            ->with('searchStartDate',$request->input('startDate'))
            ->with('searchEndDate',$request->input('endDate'))
            ->with('backgroundImages',$backgroundImages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, $id){

        $event  = Event::where('id', $id)->first();

        return view('eventSearch.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event){
        //
    }
    
    /***************************************************************************/
    /**
     * Return and HTML with all the events of a specific country by country CODE. (eg. http://websitename.com/eventSearch/country/SI)
     * this should be included in the IFRAME for the regional websites
     *
     * @param  $slug - The code of the country
     * @return \Illuminate\Http\Response
     */

    public function EventsListByCountry($code){
        $country = Country::
                where('code', $code)
                ->first();
                
        $events = Event::where('sc_country_id', $country->id)->get();
        
        $minutes = 15;  // Set the duration time of the cache
        $eventCategories = Cache::remember('categories', $minutes, function () {
            return EventCategory::orderBy('name')->pluck('name', 'id');
        });
        
        return view('eventSearch.index-iframe',compact('events'))
                ->with('country', $country)
                ->with('eventCategories',$eventCategories);
    }
    
    
    /***************************************************************************/
    /**
     * Get lastest events repetitions
     *
     * @param  $searchStartDate - The start date of the interval
     * @param  $searchEndDate - The end date of the interval
     * @return \Illuminate\Http\Response
     */
     public function getLastestEventsRepetitionsQuery($searchStartDate, $searchEndDate){
         $ret = DB::table('event_repetitions')
                     ->selectRaw('event_id, MIN(id) AS rp_id, start_repeat, end_repeat')
                     ->when($searchStartDate, function ($query, $searchStartDate) {
                         return $query->where('event_repetitions.start_repeat', '>=',$searchStartDate);
                     })
                     ->when($searchEndDate, function ($query, $searchEndDate) {
                         return $query->where('event_repetitions.end_repeat', '<=', $searchEndDate);
                     })
                     ->groupBy('event_id');
         
         return $ret;
     }
    
     /***************************************************************************/
    
    
}
