<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\Teacher;
use App\Organizer;
use App\EventVenue;
use App\Country;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        $venues = EventVenue::pluck('name', 'id');

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

        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'venue_id' => 'required',
        ]);

        $event = new Event();
        $event->title = $request->get('title');
        $event->description = $request->get('description');
        //$event->created_by = $request->get('created_by');
        $event->created_by = \Auth::user()->id;
        //$event->organized_by = $request->get('organized_by');
        //$event->slug = $request->get('slug');
        $event->slug = str_slug($event->title, '-').rand(100000, 1000000);

        $event->category_id = $request->get('category_id');
        $event->venue_id = $request->get('venue_id');

        $event->image = $request->get('image');
        $event->facebook_link = $request->get('facebook_link');
        $event->status = $request->get('status');

        $event->save();


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
        $venues = EventVenue::pluck('name', 'id');

        // Multiple teachers
            $teachersDatas = $event->teachers;
            $teachersSelected = array();
            foreach ($teachersDatas as $teacherDatas) {
                array_push($teachersSelected, $teacherDatas->id);
            }
            $multiple_teachers = implode(',', $teachersSelected);
            //dd($multiple_teachers);

        // Multiple Organizers
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

        $event->update($request->all());

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
}
