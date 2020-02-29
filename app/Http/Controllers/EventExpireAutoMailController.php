<?php

namespace App\Http\Controllers;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;
use App\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpiringEvent;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EventExpireAutoMailController extends Controller
{
    /**
     * Check if there are expiring repetat events 
     * and in case send emails to the organizers.
     *
     * @return void
     */
    public static function check(){
        $activeEvents = Event::getActiveEvents();
        $expiringEventsList = self::getExpiringRepetitiveEventsList($activeEvents);

        if(!empty($expiringEventsList)){
            self::sendEmailToExpiringEventsOrganizers($expiringEventsList);
            $message = count($expiringEventsList).' events were expiring, mails sent to the organizers.';
        }
        else{
            $message = 'No events were expiring';
        }
        Log::notice($message);
        return $message;
    }

    /**
     * Return the list of the expiring repetitive events (the 7th day from now)
     * @param  array  $activeEvents
     * @return array  $ret
     */
    public static function getExpiringRepetitiveEventsList($activeEvents){
        $ret = $activeEvents
                ->where('repeat_until', '<=', Carbon::now()->addWeek()->toDateString())
                ->where('repeat_until', '>', Carbon::now()->addWeek()->subDay()->toDateString())
                ->where('category_id', '=', '1');
        return $ret;
    }
    
    /**
     * Return the list of the expiring events titles and users
     * @param  array  $expiringEvents
     * @return array  $ret
     */
    public static function getExpiringEventsTitleAndUser($expiringEvents){
        $ret = [];
        foreach ($expiringEvents as $key => $expiringEvent) {
            $user = User::find($expiringEvents[$key]['created_by']);
            $ret[$key]['user_name'] = $user->name;
            $ret[$key]['user_email'] = $user->email;
            $ret[$key]['event_title'] = $expiringEvent['title'];
        }
        return $ret;
    }
    
    /**
     * Send an email to the events which repetitive events are expiring
     * @param  array  $expiringEvents
     * @return void
     */
    public static function sendEmailToExpiringEventsOrganizers($expiringEvents){        
        $report = [];
        
        $report['emailFrom'] = env('ADMIN_MAIL');
        $report['senderName'] = 'CI Global Calendar Administrator';
        $report['subject'] = 'CI Global Calendar Administrator';
        
        $expiringEventsTitleAndUser = self::getExpiringEventsTitleAndUser($expiringEvents);

        foreach ($expiringEventsTitleAndUser as $key => $event) {
            $report['user_name'] = $event['user_name']; 
            $report['emailTo'] = $event['user_email']; 
            $report['event_title'] = $event['event_title']; 

            //Mail::to($request->user())->send(new ReportMisuse($report));
            Mail::send(new ExpiringEvent($report));
        }
    }
}
