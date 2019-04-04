<?php

namespace App\Http\Controllers;

use App\Statistic;
use Illuminate\Http\Request;

use App\Charts\LatestUsers;

class StatisticsController extends Controller
{
    /* Restrict the access to this resource just to admin, the store method is called by Laravel Forge Deamon */
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['store']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lastUpdateStatistic = Statistic::find(\DB::table('statistics')->max('id'));
    

        $chart = new LatestUsers;
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 7]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);


        return view('stats.index')
            ->with('statsDatas', $lastUpdateStatistic)
            ->with('chart', $chart);
    }

    /***************************************************************************/

    // THIS METHOD - HAS BEEN SUBSTITUTED BY THE STATIC METHOD UPDATE STATISTICS IN THE STATISTIC MODEL

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Statistic::updateStatistics();
    }
}
