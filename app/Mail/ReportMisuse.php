<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportMisuse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The report instance.
     *
     * @var Report
     */
    protected $report;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report)
    {
         $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
         // Configure email parameters in .env file
         
         
         
         switch ($this->report['reason']) {
             
             /* Send email to the user that has created the event */
             case 'It is not translated in english':
                
                return $this->markdown('emails.misuse.organizer-event-not-english')
                 ->to($this->report['creatorEmail'])
                 ->from('noreply@globalcalendar.com', 'Global CI Calendar')
                 ->replyTo('noreply@globalcalendar.com', 'Global CI Calendar')
                 ->subject($this->report['subject'])
                 ->with([
                     'event_title' => $this->report['event_title'],
                     'event_id' => $this->report['event_id'],
                     'reason' => $this->report['reason'],
                     'msg' => $this->report['message']
                 ]);
                 
                 break;
             
             /* Send email to the administrator */
             default:
                     
                return $this->markdown('emails.misuse.administrator-report-misuse')
                    ->to($this->report['adminEmail'])
                    ->from('noreply@globalcalendar.com', 'Global CI Calendar')
                    ->replyTo('noreply@globalcalendar.com', 'Global CI Calendar')
                    ->subject($this->report['subject'])
                    ->with([
                        'event_title' => $this->report['event_title'],
                        'event_id' => $this->report['event_id'],
                        'reason' => $this->report['reason'],
                        'msg' => $this->report['message']
                    ]);
                    
                 break;
         }
         
         
     }
}
