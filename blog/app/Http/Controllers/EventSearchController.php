<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\Teacher;
use App\Organizer;
use App\EventVenue;
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
            return DB::table('event_categories')->pluck('name', 'id');
        });
        // $eventCategories = Cache::get('categories');

        $countries = Cache::remember('countries', $minutes, function () {
            return DB::table('countries')->pluck('name', 'id');
        });
        // $countries = Cache::get('countries');

        $venues = Cache::remember('venues', $minutes, function () {
            return DB::table('event_venues')->pluck('name', 'id');
        });
        //$venues = Cache::get('venues');





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
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->paginate(20);
        }
        else{
            //$events = Event::latest()->paginate(20);


            /*$events = Cache::remember('events', 30, function () {
                return DB::table('events')->latest()->paginate(20)->get();
            });*/


            /*$events = Cache::remember('events', 30, function() {
                return DB::table('events')
                    ->latest()
                    ->paginate(20);
            });*/

            // Latest give the last $eventCategories!!!
                // https://laravel.com/docs/5.7/cache
                //$events = DB::table('events')->latest()->paginate(20);

                $minutes = 30;
                $events = Cache::remember('all_events', $minutes, function () {
                    return DB::table('events')->latest()->paginate(20);
                });
        }

        return view('eventSearch.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('eventCategories',$eventCategories)->with('countries', $countries)->with('venues', $venues)->with('searchKeywords',$searchKeywords)->with('searchCategory',$searchCategory)->with('searchCountry',$searchCountry);
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
