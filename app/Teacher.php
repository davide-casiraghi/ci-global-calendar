<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name', 'bio', 'country_id', 'year_starting_practice', 'year_starting_teach', 'significant_teachers', 'profile_picture', 'website', 'facebook', 'created_by', 'slug'
    ];
    
    
    /**
     * Get the events for the teacher.
     */
    public function events()
    {
        return $this->belongsToMany('App\Event', 'event_has_teachers', 'teacher_id', 'event_id');
    }
    
}
