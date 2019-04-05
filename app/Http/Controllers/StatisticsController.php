<?php

namespace App\Http\Controllers;

use App\Statistic;
use App\User;
use App\Teacher;
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

        $usersNumberchart = $this->createUsersNumberchart(12);
        $usersByCountryChart = $this->createUsersByCountryChart();
        $teachersByCountriesChart = $this->createTeachersByCountriesChart();

        return view('stats.index')
            ->with('statsDatas', $lastUpdateStatistic)
            ->with('usersNumberchart', $usersNumberchart)
            ->with('usersByCountryChart', $usersByCountryChart)
            ->with('teachersByCountriesChart', $teachersByCountriesChart);
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
    
    /***************************************************************************/
    /**
     * Create a LINE chart showing the number of users in the last x days
     *
     * @return App\Charts
     */
    
    public function createUsersNumberchart($daysRange){
        
        $lastIDUpdatedStats = \DB::table('statistics')->max('id');
    
        $data = collect([]); // Could also be an array
        $labels = array();
        for ($days_backwards = $daysRange; $days_backwards >= 0; $days_backwards--) {
            $dayStat = Statistic::find($lastIDUpdatedStats-$days_backwards);
            $data->push($dayStat->registered_users_number);
            $labels[] = Carbon::parse($dayStat->created_at)->format('d/m');
        }
        
        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Users number', 'line', $data);
        /*$chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 7]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);*/
    
    
        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);
        
        return $ret;
    }
    
    
    /***************************************************************************/
    /**
     * Create a BAR chart showing the number of users by country
     *
     * @return App\Charts
     */
    
    public function createUsersByCountryChart(){
        $usersByCountry = User::
                        leftJoin('countries', 'users.country_id', '=', 'countries.id')
                        ->select(DB::raw('count(*) as user_count, countries.name as country_name'))
                        ->where('status', '<>', 0)
                        ->groupBy('country_id')
                        ->orderBy('country_name')
                        ->get();
        
        $data = collect([]); 
        $labels = array();
        foreach ($usersByCountry as $key => $userByCountry) {
            $data->push($userByCountry->user_count);
            $labels[] = $userByCountry->country_name;
        }
        
        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Users by Country', 'bar', $data);
        
        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);
    
        return $ret;
    
    }
    
    /***************************************************************************/
    /**
     * Create a BAR chart showing the number of users by country
     *
     * @return App\Charts
     */
    
    public function createTeachersByCountriesChart(){
    
        $teachersByCountries = Teacher::
                        leftJoin('countries', 'teachers.country_id', '=', 'countries.id')
                        ->select(DB::raw('count(*) as teacher_count, countries.name as country_name'))
                        ->groupBy('country_id')
                        ->orderBy('country_name')
                        ->get();
        
        $data = collect([]); 
        $labels = array();
        foreach ($teachersByCountries as $key => $teachersByCountry) {
            $data->push($teachersByCountry->teacher_count);
            $labels[] = $teachersByCountry->country_name;
        }
        
        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Teachers by Country', 'bar', $data);
        
        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);
    
        return $ret;
    }
    
    
    
    
    
    
    

}
