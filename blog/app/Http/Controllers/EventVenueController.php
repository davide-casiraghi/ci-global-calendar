<?php

namespace App\Http\Controllers;

use App\EventVenue;
use App\Country;

use Illuminate\Http\Request;

class EventVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $eventVenues = EventVenue::latest()->paginate(5);

        return view('eventVenues.index',compact('eventVenues'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $countries = Country::pluck('name', 'id');

        return view('eventVenues.create')->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        request()->validate([
            'name' => 'required'
        ]);

        $eventVenue = new EventVenue();
        $eventVenue->name = $request->get('name');
        $eventVenue->description = $request->get('description');
        $eventVenue->continent_id = Country::where('id', $request->get('country_id'))->pluck('continent_id')->first();
        $eventVenue->country_id = $request->get('country_id');
        $eventVenue->city = $request->get('city');
        $eventVenue->address = $request->get('address');
        $eventVenue->zip_code = $request->get('zip_code');
        $eventVenue->facebook = $request->get('facebook');
        $eventVenue->website = $request->get('website');
        $eventVenue->image = $request->get('image');

        $eventVenue->slug = str_slug($eventVenue->name, '-').rand(10000, 100000);
        $eventVenue->created_by = \Auth::user()->id;
        $eventVenue->save();

        return redirect()->route('eventVenues.index')
                        ->with('success','Event venue created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function show(EventVenue $eventVenue){
        return view('eventVenues.show',compact('eventVenue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function edit(EventVenue $eventVenue){
        $countries = Country::pluck('name', 'id');
        //dump($eventVenue);
        return view('eventVenues.edit',compact('eventVenue'))->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventVenue $eventVenue){
        request()->validate([
            'name' => 'required'
        ]);

        $eventVenue->update($request->all());

        return redirect()->route('eventVenues.index')
                        ->with('success','Event venue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventVenue $eventVenue){
        $eventVenue->delete();
        return redirect()->route('eventVenues.index')
                        ->with('success','Event venue deleted successfully');
    }
}
