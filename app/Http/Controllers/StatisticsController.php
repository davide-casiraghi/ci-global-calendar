<?php

namespace App\Http\Controllers;

use App\Statistics;
use App\Users;

use Illuminate\Http\Request;




class StatisticsController extends Controller
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
    
    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $statistics = new Statistics();
        $statistics->name = User::count();
        //$country->code = $request->get('code');
        //$country->continent_id = $request->get('continent_id');

        $statistics->save();

        dd("statistics updated");
        /*return redirect()->route('countries.index')
                        ->with('success', __('messages.country_added_successfully'));*/
    }    
    
    
    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public static function postRegisteredUsersNumber(Request $request)
    {
        
        $registeredUsersNumber = User::count();


        return $ret;   
    }*/
    
}
