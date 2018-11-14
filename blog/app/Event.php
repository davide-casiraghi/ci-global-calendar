<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'organized_by', 'category_id', 'image', 'facebook_link', 'status'
    ];

    /**
     * Get the teachers for the event.
     */
    public function teachers()
    {
        return $this->belongsToMany('App\Teacher');
    }

}
