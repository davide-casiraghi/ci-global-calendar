<?php

namespace App\Http\Controllers;

use App\EventVenue;
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
        return view('eventVenues.create');
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

        EventVenue::create($request->all());

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
        return view('eventVenues.edit',compact('eventVenue'));
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
