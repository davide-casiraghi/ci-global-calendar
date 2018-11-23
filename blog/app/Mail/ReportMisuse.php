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


         /*return $this->from($this->report->senderEmail, $this->report->senderName)
                    ->subject($this->report->subject)
                    ->to($this->report->emailTo)
                    ->markdown('emails.emailToEnrollee')
                    ->with([
                         'message' => $this->report->message."<br />".$this->report->message,
                         'sender' => $this->report->senderName,
                         'subject' => $this->report->subject,
             ]);*/
         return $this
                ->to($this->report['emailTo'])
                ->subject($this->report['subject'])
                ->view('emails.report-misuse')
                ->with([
                    'event_title' => $this->report['event_title'],
                    'event_id' => $this->report['event_id'],
                    'reason' => $this->report['reason'],
                    'msg' => $this->report['message']
                ]);
     }
}
