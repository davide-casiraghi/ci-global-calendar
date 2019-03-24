<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\User;
use App\Teacher;
use App\Organizer;
use App\Event;

class Statistic extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'statistics';

    /***************************************************************************/

    protected $fillable = [
        'registered_users_number', 'organizers_number', 'teachers_number', 'active_events_number',
    ];


    public static function updateStatistics()
    {
        $todayDate = Carbon::now()->format('d-m-Y');
        $lastUpdateStatistic = Statistic::find(\DB::table('statistics')->max('id'));
        $lastUpdateDate = ($lastUpdateStatistic != null) ? $lastUpdateStatistic->created_at->format('d-m-Y') : null;
        
        if ($lastUpdateDate != $todayDate){
            $statistics = new Statistic();
            $statistics->registered_users_number = User::count();
            $statistics->organizers_number = Organizer::count();
            $statistics->teachers_number = Teacher::count();
            $statistics->active_events_number = Event::getActiveEvents()->count();

            $statistics->save();
        }
    }


    
}
