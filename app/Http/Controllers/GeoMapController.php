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
        $activeEventMarkersGeoJSON = Event::getActiveEventsMapGeoJSON();
        //dd($activeEventMarkersGeoJSON);
        
        
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
        
        
        
        
        $test = array();
        $test = [
            "type" => "Feature",
            "id" => 2,
            "properties" => [
                "Location" => "169 Endicott St  Boston  MA  02113", 
                "OPEN_DT" => "05\/02\/2013 10:04:13 AM", 
            ],
            "geometry" => [
                "type" => "Point", 
                "coordinates" => [ -71.05729, 42.36571 ],
            ],
        ];
        
        $testJSON2 = json_encode($test);
        
        return view('geomap.index')
            ->with('testJSON', $testJSON2)
            ->with('activeEventMarkersJSON', $activeEventMarkersGeoJSON);
        
    }

}
