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
        return $this->belongsToMany('App\Teacher', 'event_has_teachers', 'event_id', 'teacher_id');
    }

    /**
     * Get the organizers for the event.
     */
    public function organizers()
    {
        return $this->belongsToMany('App\Organizer', 'event_has_organizers', 'event_id', 'organizer_id');
    }

    /**
     * Get the organizers for the event.
     */
    public function eventVenues($type = null)
    {
        return $this->belongsToMany('App\EventVenue', 'event_has_venues', 'event_id', 'venue_id');
    }


    //helper function for convenience
    public function getVenues($type){
        switch($type){
            case 'id':
                return $this->eventVenues()->wherePivot('type','id');
            case 'name': //returns films with this person in cast
                return $this->eventVenues()->wherePivot('type', 'name');
            default:
                return $this->eventVenues;
        }
    }

}
