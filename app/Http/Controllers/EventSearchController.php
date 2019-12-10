<?php

namespace App\Http\Controllers;

/*use App\Event;
use App\Country;
use App\Teacher;
use App\Continent;
use App\EventVenue;
use App\EventCategory;*/

use App\BackgroundImage;
use App\Http\Resources\Continent as ContinentResource;
use DavideCasiraghi\LaravelEventsCalendar\Facades\LaravelEventsCalendar;
use DavideCasiraghi\LaravelEventsCalendar\Models\Continent;
use DavideCasiraghi\LaravelEventsCalendar\Models\Country;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventVenue;
use DavideCasiraghi\LaravelEventsCalendar\Models\Region;
use DavideCasiraghi\LaravelEventsCalendar\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        $regions = Region::getRegionsByCountry($request->input('country_id'));

        $venues = Cache::remember('venues', $cacheExpireTime, function () {
            return EventVenue::orderBy('name')->pluck('name', 'id');
        });

        $teachers = Cache::remember('teachers', $cacheExpireTime, function () {
            return Teacher::orderBy('name')->pluck('name', 'id');
        });

        $filters = [];
        $filters['keywords'] = $request->input('keywords');
        $filters['category'] = $request->input('category_id');
        $filters['country'] = $request->input('country_id');
        $filters['region'] = $request->input('region_id');
        $filters['city'] = $request->input('city_name');
        $filters['continent'] = $request->input('continent_id');
        $filters['teacher'] = $request->input('teacher_id');
        $filters['venue'] = $request->input('venue_name');
        $filters['startDate'] = LaravelEventsCalendar::formatDatePickerDateForMysql($request->input('startDate'), 1);
        $filters['endDate'] = LaravelEventsCalendar::formatDatePickerDateForMysql($request->input('endDate'));

        $events = Event::getEvents($filters, 20);

        return view('eventSearch.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('eventCategories', $eventCategories)
            ->with('continents', $continents)
            ->with('countries', $countries)
            ->with('regions', $regions)
            ->with('venues', $venues)
            ->with('teachers', $teachers)
            ->with('searchKeywords', $filters['keywords'])
            ->with('searchCategory', $filters['category'])
            ->with('searchCountry', $filters['country'])
            ->with('searchRegion', $filters['region'])
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

    /**
     * Return the contient id of the select country
     * after a country get selected.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateContinentsDropdown(Request $request)
    {
        $selectedCountry = Country::find($request->get('country_id'));
        $ret = $selectedCountry->continent_id;

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return and HTML with the updated countries dropdown for the homepage
     * after a continent get selected.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCountriesDropdown(Request $request)
    {
        $countries = Country::getActiveCountriesByContinent($request->get('continent_id'));

        // GENERATE the HTML to return
        $ret = "<select name='country_id' id='country_id' class='selectpicker' title='".__('homepage-serach.select_a_country')."'>";
        foreach ($countries as $key => $country) {
            $ret .= "<option value='".$country->id."'>".$country->name.'</option>';
        }
        $ret .= '</select>';

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return and HTML with the updated regions dropdown for the homepage
     * after a country get selected.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRegionsDropdown(Request $request)
    {
        /*$regions = Region::join('region_translations', 'regions.id', '=', 'region_translations.region_id')
                ->where('locale', 'en')
                ->where('country_id', $request->input('country_id'))
                ->orderBy('name')
                ->pluck('name','region_translations.region_id AS id'); */

        $regions = Region::
                select('name', 'region_translations.region_id AS id')
                ->join('region_translations', 'regions.id', '=', 'region_translations.region_id')
                ->where('locale', 'en')
                ->where('country_id', $request->input('country_id'))
                ->orderBy('name')
                ->get();

        // GENERATE the HTML to return
        $ret = "<select name='region_id' id='region_id' class='selectpicker' title='".__('homepage-serach.select_a_region')."'>";
        foreach ($regions as $key => $region) {
            $ret .= "<option value='".$region->id."'>".$region->name.'</option>';
        }
        $ret .= '</select>';

        return $ret;
    }
}
