<?php

namespace App\Http\Controllers;

use App\Statistic;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


        /* USERS NUMBER */
            $lastIDUpdatedStats = \DB::table('statistics')->max('id');
        
            $data = collect([]); // Could also be an array
            $labels = array();
            for ($days_backwards = 12; $days_backwards >= 0; $days_backwards--) {
                $dayStat = Statistic::find($lastIDUpdatedStats-$days_backwards);
                $data->push($dayStat->registered_users_number);
                $labels[] = Carbon::parse($dayStat->created_at)->format('d/m');
            }
            
            $usersNumberchart = new LatestUsers;
            $usersNumberchart->labels($labels);
            $dataset = $usersNumberchart->dataset('Users number', 'line', $data);
            /*$chart->labels(['One', 'Two', 'Three', 'Four']);
            $chart->dataset('My dataset', 'line', [1, 2, 3, 7]);
            $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);*/
        
        
            //https://www.chartjs.org/docs/latest/charts/line.html
            $dataset->options([
                'borderColor' => '#2669A0',
            ]);

        /* USERS BY COUNTRY */
            $usersByCountry = User::
                            leftJoin('countries', 'users.country_id', '=', 'countries.id')
                            ->select(DB::raw('count(*) as user_count, countries.name as country_name'))
                            ->where('status', '<>', 0)
                            ->groupBy('country_id')
                            ->get();
            //dd($usersByCountry);
            
            $data = collect([]); // Could also be an array
            $labels = array();
            foreach ($usersByCountry as $key => $userByCountry) {
                $data->push($userByCountry->user_count);
                $labels[] = $userByCountry->country_name;
            }
            
            $usersByCountryChart = new LatestUsers;
            $usersByCountryChart->labels($labels);
            $usersByCountryChartDataset = $usersByCountryChart->dataset('Users by Country', 'bar', $data);
            
            //https://www.chartjs.org/docs/latest/charts/line.html
            $usersByCountryChartDataset->options([
                'borderColor' => '#2669A0',
            ]);
            
            


        return view('stats.index')
            ->with('statsDatas', $lastUpdateStatistic)
            ->with('usersNumberchart', $usersNumberchart)
            ->with('usersByCountryChart', $usersByCountryChart);
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
