<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


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



    
}
