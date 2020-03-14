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
    
        //$clientIP = $request->ip();
        //$userPosition = geoip($ip = null);
        //dd($userPosition);
        
        return view('geomap.index')
            ->with('activeEventMarkersJSON', $activeEventMarkersGeoJSON);
        
    }
    
    


}
