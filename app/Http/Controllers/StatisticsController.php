<?php

namespace App\Http\Controllers;

use App\Statistic;
use App\User;
use App\Teacher;
use App\Organizer;
use App\Event;

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

        $statistics = new Statistic();
        $statistics->registered_users_number = User::count();
        $statistics->organizers_number = Organizer::count();
        $statistics->teachers_number = Teacher::count();
        $statistics->active_events_number = Event::getActiveEvents()::count();


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
