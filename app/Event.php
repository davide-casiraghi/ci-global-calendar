<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

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
     * Return the active events collection.
     *
     * @param  int  event id
     * @return \App\Event the active events
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
}
