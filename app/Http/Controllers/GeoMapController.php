<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;

use Illuminate\Http\Request;

class GeoMapController extends Controller
{
    /***************************************************************************/

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeEventMarkers = Event::getActiveEventsMapMarkers();
        //dd($activeEventMarkers);
        
        
        $testJSON = '{
            "type": "Feature", 
            "id": 2, 
            "properties": { 
                "CASE_ENQUIRY_ID": 101000832197.0, 
                "OPEN_DT": "05\/02\/2013 10:04:13 AM", 
                "CASE_STATUS": "Open", 
                "CASE_TITLE": "Rodent Activity", 
                "SUBJECT": "Inspectional Services", 
                "TYPE": "Rodent Activity", 
                "Location": "169 Endicott St  Boston  MA  02113", 
                "LOCATION_STREET_NAME": "169 Endicott St", 
                "LOCATION_ZIPCODE": 2113, 
                "LATITUDE": 42.36571, 
                "LONGITUDE": -71.05729, 
            }
            , "geometry": { "type": "Point", "coordinates": [ -71.05729, 42.36571 ] } 
        }';
        
        
        $activeEventMarkersJSON = json_encode($activeEventMarkers);
        
        //dd($activeEventMarkers[0]->lat);
        return view('geomap.index')
            ->with('testJSON', $testJSON)
            ->with('activeEventMarkersJSON', $activeEventMarkersJSON);
        /*return view('stats.index')
            ->with('statsDatas', $lastUpdateStatistic)
            ->with('registeredUsersChart', $registeredUsersChart)
            ->with('usersByCountryChart', $usersByCountryChart)
            ->with('teachersByCountriesChart', $teachersByCountriesChart)
            ->with('eventsByCountriesChart', $eventsByCountriesChart);
        //->with('organizersByCountriesChart', $organizersByCountriesChart);*/
    }

}
