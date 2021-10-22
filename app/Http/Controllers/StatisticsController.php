<?php

namespace App\Http\Controllers;

use App\Charts\LatestUsers;
use App\Statistic;
use App\User;
use Carbon\Carbon;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;
use DavideCasiraghi\LaravelEventsCalendar\Models\Organizer;
use DavideCasiraghi\LaravelEventsCalendar\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $lastUpdateStatistic = Statistic::find(\DB::table('statistics')->max('id'));

        $registeredUsersChart = $this->createLinesChart(12);

        $usersByCountryChart = $this->createUsersByCountryChart();
        $teachersByCountriesChart = $this->createTeachersByCountriesChart();
        $eventsByCountriesChart = $this->createEventsByCountriesChart();
        //$organizersByCountriesChart = $this->createOrganizersByCountriesChart();

        return view('stats.index')
            ->with('statsDatas', $lastUpdateStatistic)
            ->with('registeredUsersChart', $registeredUsersChart)
            ->with('usersByCountryChart', $usersByCountryChart)
            ->with('teachersByCountriesChart', $teachersByCountriesChart)
            ->with('eventsByCountriesChart', $eventsByCountriesChart);
        //->with('organizersByCountriesChart', $organizersByCountriesChart);
    }

    /***************************************************************************/

    // THIS METHOD - HAS BEEN SUBSTITUTED BY THE STATIC METHOD UPDATE STATISTICS IN THE STATISTIC MODEL

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store()
    {
        Statistic::updateStatistics();
    }

    /***************************************************************************/

    /**
     * Create a LINE chart showing the number of users in the last x days.
     *
     * @param  int  $daysRange
     * @return \App\Charts\LatestUsers
     */
    public function createLinesChart($daysRange)
    {
        $lastIDUpdatedStats = \DB::table('statistics')->max('id');

        /* Registered users*/
        $dataRegisteredUsers = collect([]);
        $dataOrganizerProfiles = collect([]);
        $dataTeacherProfiles = collect([]);
        $dataActiveEvents = collect([]);

        $labels = [];
        for ($days_backwards = $daysRange; $days_backwards >= 0; $days_backwards--) {
            $dayStat = Statistic::find($lastIDUpdatedStats - $days_backwards);
            $dataRegisteredUsers->push($dayStat->registered_users_number);
            $dataOrganizerProfiles->push($dayStat->organizers_number);
            $dataTeacherProfiles->push($dayStat->teachers_number);
            $dataActiveEvents->push($dayStat->active_events_number);
            $labels[] = Carbon::parse($dayStat->created_at)->format('d/m');
        }

        $ret = new LatestUsers;

        $ret->labels($labels);
        $dataset = $ret->dataset('Registered Users', 'line', $dataRegisteredUsers)
            ->options([
                'borderColor' => '#2669A0',
                'backgroundColor' => '#2669A0',
                'fill' => false,
            ]);

        $ret->dataset('Organizer Profiles', 'line', $dataOrganizerProfiles)
            ->options([
                'borderColor' => '#a12d97',
                'backgroundColor' => '#a12d97',
                'fill' => false,
            ]);

        $ret->dataset('Teacher Profiles', 'line', $dataTeacherProfiles)
            ->options([
                'borderColor' => '#e8af17',
                'backgroundColor' => '#e8af17',
                'fill' => false,
            ]);

        $ret->dataset('Active Events', 'line', $dataActiveEvents)
            ->options([
                'borderColor' => '#297446',
                'backgroundColor' => '#297446',
                'fill' => false,
            ]);

        /*$chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 7]);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);*/

        //https://www.chartjs.org/docs/latest/charts/line.html

        return $ret;
    }

    /***************************************************************************/

    /**
     * Create a BAR chart showing the number of Users by country.
     *
     * @return \App\Charts\LatestUsers
     */
    public function createUsersByCountryChart()
    {
        $usersByCountry = User::leftJoin('countries', 'users.country_id', '=', 'countries.id')
                        ->select(DB::raw('count(*) as user_count, countries.name as country_name'))
                        ->where('status', '<>', 0)
                        ->groupBy('country_id')
                        ->orderBy('country_name')
                        ->get();

        $data = collect([]);
        $labels = [];
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
     * Create a BAR chart showing the number of Teachers by country.
     *
     * @return \App\Charts\LatestUsers
     */
    public function createTeachersByCountriesChart()
    {
        $teachersByCountries = Teacher::leftJoin('countries', 'teachers.country_id', '=', 'countries.id')
                        ->select(DB::raw('count(*) as teacher_count, countries.name as country_name'))
                        ->groupBy('country_id')
                        ->orderBy('country_name')
                        ->get();

        $data = collect([]);
        $labels = [];
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

    /***************************************************************************/

    /**
     * Create a BAR chart showing the number of Organizers by country.
     *
     * @return \App\Charts\LatestUsers
     */
    public function createOrganizersByCountriesChart()
    {
        $organizersByCountries = Organizer::leftJoin('countries', 'organizers.country_id', '=', 'countries.id')
                        ->select(DB::raw('count(*) as organizer_count, countries.name as country_name'))
                        ->groupBy('country_id')
                        ->orderBy('country_name')
                        ->get();
        //dd($organizersByCountries);
        $data = collect([]);
        $labels = [];
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

    /***************************************************************************/

    /**
     * Create a BAR chart showing the number of Events by country.
     *
     * @return \App\Charts\LatestUsers
     */
    public function createEventsByCountriesChart()
    {
        //$eventsByCountries = Event::getActiveEvents();

        $filters = [];
        $filters['keywords'] = $filters['category'] = $filters['country'] = $filters['region'] = $filters['city'] = $filters['continent'] = $filters['teacher'] = $filters['venue'] = $filters['startDate'] = $filters['endDate'] = null;
        $activeEvents = Event::getEvents($filters, 10000);

        $grouped = $activeEvents->groupBy(function ($item, $key) {
            return $item['country_name'];
        });
        $eventsByCountries = $grouped->map(function ($item, $key) {
            return collect($item)->count();
        });
        $eventsByCountries = $eventsByCountries->sortKeys();

        $data = collect([]);
        $labels = [];
        foreach ($eventsByCountries as $key => $eventsByCountry) {
            $data->push($eventsByCountry);
            $labels[] = $key;
        }

        $ret = new LatestUsers;
        $ret->labels($labels);
        $dataset = $ret->dataset('Events by Country', 'bar', $data);

        //https://www.chartjs.org/docs/latest/charts/line.html
        $dataset->options([
            'borderColor' => '#2669A0',
        ]);

        return $ret;
    }
}
