<?php

namespace App\Http\Controllers;

use DavideCasiraghi\LaravelEventsCalendar\Models\Event;
use Illuminate\Http\Request;

class GeoMapController extends Controller
{
    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeEventMarkersGeoJSON = Event::getActiveEventsMapGeoJSON();

        //dd($activeEventMarkersGeoJSON);

        $userIp = $request->ip();
        $userPosition = geoip($userIp);

        $userLat = $userPosition['lat'];
        $userLng = $userPosition['lon'];

        return view('geomap.index')
            ->with('activeEventMarkersJSON', $activeEventMarkersGeoJSON)
            ->with('userLat', $userLat)
            ->with('userLng', $userLng);
    }
}
