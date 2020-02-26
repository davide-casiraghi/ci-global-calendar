<?php

namespace App\Http\Controllers;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EventExpireAutoMailController extends Controller
{
    /**
     * Check if an event is expiring
     * @param  \DavideCasiraghi\LaravelEventsCalendar\Models\Event  $event
     * @return boolean
     */
    /*public static function checkEventExpire($event){
        $ret = true;
        
        return $ret;
    }*/

    /**
     * Return the list of the expiring repetitive events (the 7th day from now)
     * @param  \DavideCasiraghi\LaravelEventsCalendar\Models\Event  $events
     * @return \DavideCasiraghi\LaravelEventsCalendar\Models\Event  $ret
     */
    public static function getExpiringRepetitiveEventsList($events){
        $ret = $events
                ->where('repeat_until', '<=', Carbon::now()->addWeek()->toDateString())
                ->where('repeat_until', '>', Carbon::now()->addWeek()->subDay()->toDateString())
                ->where('category_id', '=', '1');
        return $ret;
    }
    
    /**
     * Send an email to the events which repetitive events are expiring
     * @param  \DavideCasiraghi\LaravelEventsCalendar\Models\Event  $events
     * @return void
     */
    public function sendEmailToExpiringEventsOrganizers(){
        
    }
        
}
