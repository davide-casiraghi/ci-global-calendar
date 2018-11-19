<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRepetition extends Model
{
    protected $fillable = [
        'event_id', 'start_repeat', 'end_repeat'
    ];

    public function user()
    {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }
}
