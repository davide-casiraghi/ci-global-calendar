<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teachers';

    /***************************************************************************/

    protected $fillable = [
        'name', 'bio', 'country_id', 'year_starting_practice', 'year_starting_teach', 'significant_teachers', 'profile_picture', 'website', 'facebook', 'created_by', 'slug',
    ];

    /**
     * Get the events for the teacher.
     */
    public function events()
    {
        return $this->belongsToMany('App\Event', 'event_has_teachers', 'teacher_id', 'event_id');
    }

    /***************************************************************************/

    /**
     * Get the events where this teacher is going to teach to.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public static function eventsByTeacher($teacher, $lastestEventsRepetitionsQuery, $searchStartDate)
    {
        $ret = $teacher->events()
                         ->select('events.title', 'events.category_id', 'events.slug', 'events.venue_id', 'events.sc_venue_name', 'events.sc_country_name', 'events.sc_city_name', 'events.sc_teachers_names', 'event_repetitions.start_repeat', 'event_repetitions.end_repeat')
                         ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) use ($searchStartDate) {
                             $join->on('events.id', '=', 'event_repetitions.event_id');
                         })
                         ->orderBy('event_repetitions.start_repeat', 'asc')
                         ->get();

        return $ret;
    }
}
