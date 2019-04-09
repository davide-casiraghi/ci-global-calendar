<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Country;
use App\EventVenue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EventVenueController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show view */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cacheExpireTime = 900; // Set the duration time of the cache (15 min - 900sec)
        $countries = Cache::remember('countries', $cacheExpireTime, function () {
            return Country::orderBy('name')->pluck('name', 'id');
        });

        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

        // To show just the veues created by the the user - If admin or super admin is set to null show all the venues
        $authorUserId = ($this->getLoggedAuthorId()) ? $this->getLoggedAuthorId() : null;

        if ($searchKeywords || $searchCountry) {
            $eventVenues = DB::table('event_venues')
                ->when($authorUserId, function ($query, $authorUserId) {
                    return $query->where('created_by', $authorUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->orderBy('name')
                ->paginate(20);
        } else {
            $eventVenues = EventVenue::
                when($authorUserId, function ($query, $authorUserId) {
                    return $query->where('created_by', $authorUserId);
                })
                ->orderBy('name')
                ->paginate(20);
        }
        //dd(DB::getQueryLog());

        return view('eventVenues.index', compact('eventVenues'))
                ->with('i', (request()->input('page', 1) - 1) * 20)
                ->with('countries', $countries)
                ->with('searchKeywords', $searchKeywords)
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
        $authorUserId = $this->getLoggedUser();
        $users = User::pluck('name', 'id');
        $countries = Country::getCountries();

        return view('eventVenues.create')
                ->with('countries', $countries)
                ->with('users', $users)
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
        $validator = $this->eventsVenueValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $eventVenue = new EventVenue();

        $this->saveOnDb($request, $eventVenue);

        return redirect()->route('eventVenues.index')
                        ->with('success', __('messages.venue_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function show(EventVenue $eventVenue)
    {
        $country = DB::table('countries')
                ->select('id', 'name', 'continent_id')
                ->where('id', $eventVenue->country_id)
                ->first();

        return view('eventVenues.show', compact('eventVenue'))->with('country', $country);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function edit(EventVenue $eventVenue)
    {
        if (Auth::user()->id == $eventVenue->created_by || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            $authorUserId = $this->getLoggedAuthorId();
            $users = User::pluck('name', 'id');
            $countries = Country::getCountries();

            return view('eventVenues.edit', compact('eventVenue'))
                ->with('countries', $countries)
                ->with('users', $users)
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
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventVenue $eventVenue)
    {
        // Validate form datas
        $validator = $this->eventsVenueValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //$eventVenue->update($request->all());
        $this->saveOnDb($request, $eventVenue);

        return redirect()->route('eventVenues.index')
                        ->with('success', __('messages.venue_updated_successfully'));
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventVenue $eventVenue)
    {
        $eventVenue->delete();

        return redirect()->route('eventVenues.index')
                        ->with('success', __('messages.venue_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function saveOnDb($request, $eventVenue)
    {
        $eventVenue->name = $request->get('name');
        //$eventVenue->description = $request->get('description');
        $eventVenue->description = clean($request->get('description'));
        $eventVenue->continent_id = Country::where('id', $request->get('country_id'))->pluck('continent_id')->first();
        $eventVenue->country_id = $request->get('country_id');
        $eventVenue->city = $request->get('city');
        $eventVenue->state_province = $request->get('state_province');
        $eventVenue->address = $request->get('address');
        $eventVenue->zip_code = $request->get('zip_code');
        $eventVenue->website = $request->get('website');

        if (! $eventVenue->slug) {
            $eventVenue->slug = Str::slug($eventVenue->name, '-').rand(10000, 100000);
        }
        $eventVenue->created_by = \Auth::user()->id;
        $eventVenue->save();
    }

    /***************************************************************************/

    /**
     * Open a modal in the event view when create teachers is clicked.
     *
     * @return view
     */
    public function modal()
    {
        $countries = Country::getCountries();

        return view('eventVenues.modal')->with('countries', $countries);
    }

    /***************************************************************************/

    /**
     * Store a newly created teacher from the create event view modal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromModal(Request $request)
    {
        $eventVenue = new EventVenue();

        request()->validate([
            'name' => 'required',
        ]);

        $this->saveOnDb($request, $eventVenue);

        return redirect()->back()->with('message', __('messages.venue_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Return the Venue validator with all the defined constraint.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function eventsVenueValidator($request)
    {
        $rules = [
            'name' => 'required',
            'city' => 'required',
            'country_id' => 'required',
            'website' => 'nullable|url',
        ];
        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
}
