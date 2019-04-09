<?php

namespace App\Http\Controllers;

use App\Event;
use App\Country;
use App\Teacher;
use App\Continent;
use App\EventVenue;
use App\EventCategory;
use App\BackgroundImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Continent as ContinentResource;

class EventSearchController extends Controller
{
    // **********************************************************************

    /**
     * Display the event search results in Global Calendar Homepage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cacheExpireTime = 900; // expressed in seconds (15 min)

        $backgroundImages = BackgroundImage::all();

        $eventCategories = Cache::remember('categories', $cacheExpireTime, function () {
            return EventCategory::orderBy('name')->pluck('name', 'id');
        });

        // Get the countries with active events
        $activeEvents = Event::getActiveEvents();
        $countries = $activeEvents->unique('country_name')->sortBy('country_name')->pluck('country_name', 'country_id');
        //$cities = $activeEvents->unique('city')->toArray();
        $activeContinentsCountries = ContinentResource::collection(Continent::all());

        $continents = Cache::rememberForever('continents', function () {
            return Continent::orderBy('name')->pluck('name', 'id');
        });

        $venues = Cache::remember('venues', $cacheExpireTime, function () {
            return EventVenue::pluck('name', 'id');
        });

        $teachers = Cache::remember('teachers', $cacheExpireTime, function () {
            return Teacher::orderBy('name')->pluck('name', 'id');
        });

        $filters = [];
        $filters['keywords'] = $request->input('keywords');
        $filters['category'] = $request->input('category_id');
        $filters['country'] = $request->input('country_id');
        $filters['city'] = $request->input('city_name');
        $filters['continent'] = $request->input('continent_id');
        $filters['teacher'] = $request->input('teacher_id');
        $filters['venue'] = $request->input('venue_name');
        $filters['startDate'] = Event::prepareStartDate($request->input('startDate'));
        $filters['endDate'] = Event::prepareEndDate($request->input('endDate'));

        $events = Event::getEvents($filters, 20);

        return view('eventSearch.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('eventCategories', $eventCategories)
            ->with('continents', $continents)
            ->with('countries', $countries)
            ->with('venues', $venues)
            ->with('teachers', $teachers)
            ->with('searchKeywords', $filters['keywords'])
            ->with('searchCategory', $filters['category'])
            ->with('searchCountry', $filters['country'])
            ->with('searchContinent', $filters['continent'])
            ->with('searchCity', $filters['city'])
            ->with('searchTeacher', $filters['teacher'])
            ->with('searchVenue', $filters['venue'])
            ->with('searchStartDate', $request->input('startDate'))
            ->with('searchEndDate', $request->input('endDate'))
            ->with('backgroundImages', $backgroundImages)
            ->with('activeContinentsCountries', $activeContinentsCountries);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, $id)
    {
        $event = Event::where('id', $id)->first();

        return view('eventSearch.show', compact('event'));
    }

    /***************************************************************************/

    /**
     * Return and HTML with all the events of a specific country by country CODE. (eg. http://websitename.com/eventSearch/country/SI)
     * this should be included in the IFRAME for the regional websites.
     *
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function EventsListByCountry($code)
    {
        $country = Country::where('code', $code)->first();

        $filters = [];
        $filters['keywords'] = $filters['category'] = $filters['city'] = $filters['continent'] = $filters['teacher'] = $filters['venue'] = $filters['startDate'] = $filters['endDate'] = null;
        $filters['country'] = $country->id;
        $events = Event::getEvents($filters, null);

        $cacheExpireTime = 900; // Set the duration time of the cache (15 min - 900sec)
        $eventCategories = Cache::remember('categories', $cacheExpireTime, function () {
            return EventCategory::orderBy('name')->pluck('name', 'id');
        });

        return view('eventSearch.index-iframe', compact('events'))
                ->with('country', $country)
                ->with('eventCategories', $eventCategories);
    }

    /***************************************************************************/
}
