<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /***************************************************************************/

    protected $fillable = [
        'title', 'description', 'organized_by', 'category_id', 'venue_id', 'image', 'facebook_event_link', 'website_event_link', 'status', 'repeat_type', 'repeat_until', 'repeat_weekly_on', 'repeat_monthly_on', 'on_monthly_kind',
    ];

    /***************************************************************************/

    /**
     * Get the teachers for the event.
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher', 'event_has_teachers', 'event_id', 'teacher_id');
    }

    /***************************************************************************/

    /**
     * Get the organizers for the event.
     */
    public function organizers()
    {
        return $this->belongsToMany('App\Organizer', 'event_has_organizers', 'event_id', 'organizer_id');
    }

    /***************************************************************************/

    /**
     * Get the organizers for the event.
     */
    public function eventRepetitions($type = null)
    {
        return $this->hasMany('App\EventRepetition', 'event_id');
    }

    /***************************************************************************/

    /**
     * Delete all the previous repetitions from the event_repetitions table.
     *
     * @param  $eventId - Event id
     * @return none
     */
    public static function deletePreviousRepetitions($eventId)
    {
        EventRepetition::where('event_id', $eventId)->delete();
    }

    /***************************************************************************/

    /**
     * Return Start and End dates of the first repetition of an event - By Event ID.
     *
     * @param  int  event id
     * @return \App\EventRepetition the event repetition Start and End repeat dates
     */
    public static function getFirstEventRpDatesByEventId($eventId)
    {
        $ret = EventRepetition::
                select('start_repeat', 'end_repeat')
                ->where('event_id', $eventId)
                ->first();

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return Start and End dates of the first repetition of an event - By Repetition ID.
     *
     * @param  int  event id
     * @return \App\EventRepetition the event repetition Start and End repeat dates
     */
    public static function getFirstEventRpDatesByRepetitionId($repetitionId)
    {
        $ret = EventRepetition::
                select('start_repeat', 'end_repeat')
                ->where('id', $repetitionId)
                ->first();

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the all the active events.
     *
     * @param  int  event id
     * @return \App\Event the active events collection
     */
    public static function getActiveEvents()
    {
        $cacheExpireMinutes = 15; // Set the duration time of the cache

        $ret = Cache::remember('active_events', $cacheExpireMinutes, function () {
            date_default_timezone_set('Europe/Rome');
            $searchStartDate = date('Y-m-d', time());
            $lastestEventsRepetitionsQuery = EventRepetition::getLastestEventsRepetitionsQuery($searchStartDate, null);

            return Event::
                        select('title', 'countries.name AS country_name', 'countries.id AS country_id', 'countries.continent_id AS continent_id', 'event_venues.city AS city')
                        ->join('event_venues', 'event_venues.id', '=', 'events.venue_id')
                        ->join('countries', 'countries.id', '=', 'event_venues.country_id')
                        ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) use ($searchStartDate) {
                            $join->on('events.id', '=', 'event_repetitions.event_id');
                        })
                        ->get();
        });

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the active events based on the search keys provided.
     *
     * @param  int  event id
     * @return \App\Event the active events collection
     */
    public static function getEvents($keywords, $category, $city, $country, $continent, $teacher, $venue, $startDate, $endDate, $itemPerPage)
    {
        // Sub-Query Joins - https://laravel.com/docs/5.7/queries
        $lastestEventsRepetitionsQuery = EventRepetition::getLastestEventsRepetitionsQuery($startDate, $endDate);

        // Retrieve the events that correspond to the selected filters
        if ($keywords || $category || $city || $country || $continent || $teacher || $venue || $endDate) {
            //dd($keywords." - ".$category." - ".$city." - ".$country." - ".$continent." - ".$teacher." - ".$venue." - ".$startDate." - ".$endDate);
            //DB::enableQueryLog();
            $ret = self::
                    when($keywords, function ($query, $keywords) {
                        return $query->where('title', 'like', '%'.$keywords.'%');
                    })
                    ->when($category, function ($query, $category) {
                        return $query->where('category_id', '=', $category);
                    })
                    ->when($teacher, function ($query, $teacher) {
                        return $query->whereRaw('json_contains(sc_teachers_id, \'["'.$teacher.'"]\')');
                    })
                    ->when($country, function ($query, $country) {
                        return $query->where('sc_country_id', '=', $country);
                    })
                    ->when($continent, function ($query, $continent) {
                        return $query->where('sc_continent_id', '=', $continent);
                    })
                    ->when($city, function ($query, $city) {
                        return $query->where('sc_city_name', 'like', '%'.$city.'%');
                    })
                    ->when($venue, function ($query, $venue) {
                        return $query->where('sc_venue_name', 'like', '%'.$venue.'%');
                    })
                    ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) use ($startDate,$endDate) {
                        $join->on('events.id', '=', 'event_repetitions.event_id');
                    })
                    ->orderBy('event_repetitions.start_repeat', 'asc')
                    ->paginate($itemPerPage);
        //dd(DB::getQueryLog());
        }
        // If no filter selected retrieve all the events
        else {
            if (!$startDate) $startDate = Carbon::now()->format('Y-m-d');
                
            $ret = self::
                         where('event_repetitions.start_repeat', '>=', $startDate)
                        ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) {
                            $join->on('events.id', '=', 'event_repetitions.event_id');
                        })
                        ->orderBy('event_repetitions.start_repeat', 'asc')
                        ->paginate($itemPerPage);

            // It works, but I don't use it now to develop
                /*$cacheExpireMinutes = 30;
                $events = Cache::remember('all_events', $cacheExpireTime, function () {
                    return DB::table('events')->latest()->paginate(20);
                });*/
        }

        return $ret;
    }

    /***************************************************************************/

    /**
     * Format the start date to be used in the search query.
     * If the start date is null return today's date.
     *
     * @param  int  event id
     * @return \App\Event the active events collection
     */
    public static function prepareStartDate($DatePickerStartDate)
    {
        if ($DatePickerStartDate) {
            list($tid, $tim, $tiy) = explode('/', $DatePickerStartDate);
            $ret = "$tiy-$tim-$tid";
        } else {
            // If no start date selected the search start from today's date
            date_default_timezone_set('Europe/Rome');
            $ret = date('Y-m-d', time());
        }

        return $ret;
    }

    /***************************************************************************/

    /**
     * Format the edn date to be used in the search query.
     *
     * @param  int  event id
     * @return \App\Event the active events collection
     */
    public static function prepareEndDate($DatePickerEndDate)
    {
        if ($DatePickerEndDate) {
            list($tid, $tim, $tiy) = explode('/', $DatePickerEndDate);
            $ret = "$tiy-$tim-$tid";
        } else {
            $ret = null;
        }

        return $ret;
    }
}
