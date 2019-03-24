<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statsDatas = [
            'registeredUsersNumber' => 33,
            'organizersNumber' => 11,
            'teachersNumber' => 22,
            'activeEventsNumber' => 88,
        ];
        
        return view('stats.index')
            ->with('statsDatas', $statsDatas);    
    }
}
