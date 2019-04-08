<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRepetition extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_repetitions';

    /***************************************************************************/

    protected $fillable = [
        'event_id', 'start_repeat', 'end_repeat',
    ];

    public function user()
    {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

    /***************************************************************************/

    /**
     * Get for each event the first event repetition in the near future (JUST THE QUERY to use as SUBQUERY).
     * Parameters are Start date and End date of the interval
     * Return the query string,.
     * @param  string $searchStartDate
     * @param  string $searchEndDate
     * @return string
     */
    public static function getLastestEventsRepetitionsQuery($searchStartDate, $searchEndDate)
    {
        $ret = self::
                     selectRaw('event_id, MIN(id) AS rp_id, start_repeat, end_repeat')
                     ->when($searchStartDate, function ($query, $searchStartDate) {
                         return $query->where('event_repetitions.start_repeat', '>=', $searchStartDate);
                     })
                     ->when($searchEndDate, function ($query, $searchEndDate) {
                         return $query->where('event_repetitions.end_repeat', '<=', $searchEndDate);
                     })
                     ->groupBy('event_id');

        return $ret;
    }
}
