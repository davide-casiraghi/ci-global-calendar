<?php

namespace App\Http\Controllers;

use App\EventVenue;
use App\Country;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $countries = Country::pluck('name', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

        // Show just to the owner - Get created_by value if the user is not an admin or super admin
        $user = Auth::user();
        $createdBy = (!$user->isSuperAdmin()&&!$user->isAdmin()) ? $user->id : 0;

        if ($searchKeywords||$searchCountry){
            $eventVenues = DB::table('event_venues')
                ->when($createdBy, function ($query, $createdBy) {
                    return $query->where('created_by', $createdBy);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->paginate(20);
        }
        else
            $eventVenues = EventVenue::latest()
                ->when($createdBy, function ($query, $createdBy) {
                    return $query->where('created_by', $createdBy);
                })
                ->paginate(20);

        return view('eventVenues.index',compact('eventVenues'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('countries', $countries)->with('searchKeywords',$searchKeywords)->with('searchCountry',$searchCountry);
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
        $country = DB::table('countries')
                ->select('id','name','continent_id')
                ->where('id',$eventVenue->country_id)
                ->first();

        return view('eventVenues.show',compact('eventVenue'))->with('country', $country);
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
