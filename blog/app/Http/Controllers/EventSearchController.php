<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\Teacher;
use App\Organizer;
use App\EventVenue;
use App\Continent;
use App\Country;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EventSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        /*$eventCategories = EventCategory::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $venues = EventVenue::pluck('name', 'id');*/


        $minutes = 30;

        $eventCategories = Cache::remember('categories', $minutes, function () {
            return EventCategory::pluck('name', 'id');
        });


        $countries = Cache::rememberForever('countries', function () {
            return Country::pluck('name', 'id');
        });

        $continents = Cache::rememberForever('continents', function () {
            return Continent::pluck('name', 'id');
        });


        $venues = Cache::remember('venues', $minutes, function () {
            return EventVenue::pluck('name', 'id');
        });


        $teachers = Cache::remember('teachers', $minutes, function () {
            return Teacher::pluck('name', 'id');
        });

        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');
        $searchCountry = $request->input('country_id');
        $searchContinent = $request->input('continent_id');
        $searchTeacher = $request->input('teacher_id');


        if ($searchKeywords||$searchCategory||$searchCountry||$searchContinent||$searchTeacher){

            /*$events = DB::table('events')
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('category_id', '=', $searchCategory);
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->paginate(20);*/

                $events = Event::
                    when($searchKeywords, function ($query, $searchKeywords) {
                        return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%' . $searchKeywords . '%');
                    })
                    ->when($searchCategory, function ($query, $searchCategory) {
                        return $query->where('category_id', '=', $searchCategory);
                    })
                    ->when($searchCountry, function ($query, $searchCountry) {
                        return $query->where('sc_country_id', '=', $searchCountry);
                        //return $query->join('event_venues', 'events.venue_id', '=', 'event_venues.id')->where('event_venues.country_id', '=', $searchCountry);
                    })
                    ->when($searchContinent, function ($query, $searchContinent) {
                        return $query->where('sc_continent_id', '=', $searchContinent);
                        //return $query->where('country_id', '=', $searchContinent);
                    })
                    ->paginate(20);
        }
        else{
            //$events = Event::latest()->paginate(20);

            // Latest give the last $eventCategories!!!
                $events = DB::table('events')->latest()->paginate(20);

                // It works, but I don't use it now to develop
                /*$minutes = 30;
                $events = Cache::remember('all_events', $minutes, function () {
                    return DB::table('events')->latest()->paginate(20);
                });*/
        }

        return view('eventSearch.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('eventCategories',$eventCategories)->with('continents', $continents)->with('countries', $countries)->with('venues', $venues)->with('teachers', $teachers)->with('searchKeywords',$searchKeywords)->with('searchCategory',$searchCategory)->with('searchCountry',$searchCountry)->with('searchContinent',$searchContinent)->with('searchTeacher',$searchTeacher);
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
}
