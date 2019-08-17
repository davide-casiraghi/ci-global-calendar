<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

use DavideCasiraghi\LaravelEventsCalendar\Models\Organizer;
use DavideCasiraghi\LaravelEventsCalendar\Models\Teacher;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;


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
        $lastUpdateStatistic = self::find(\DB::table('statistics')->max('id'));
        $lastUpdateDate = ($lastUpdateStatistic != null) ? $lastUpdateStatistic->created_at->format('d-m-Y') : null;

        if ($lastUpdateDate != $todayDate) {
            $statistics = new self();
            $statistics->registered_users_number = User::count();
            $statistics->organizers_number = Organizer::count();
            $statistics->teachers_number = Teacher::count();
            $statistics->active_events_number = Event::getActiveEvents()->count();

            $statistics->save();

            Log::notice('statistics updated');
        //echo 'statistics updated';
        } else {
            Log::notice('the statistics have been already updated today');
            //echo 'the statistics have been already updated today';
        }
    }
}
