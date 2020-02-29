<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The report instance.
     *
     * @var array
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

        return $this->markdown('emails.expiringevent')
                ->to($this->report['emailTo'])
                ->from($this->report['emailFrom'], $this->report['senderName'])
                ->replyTo($this->report['emailFrom'], $this->report['senderName'])
                ->subject($this->report['subject'])
                ->with([
                    'user_name' => $this->report['user_name'],
                    'event_title' => $this->report['event_title'],
                    'sender_email' => $this->report['emailFrom'],
                    'sender_name' => $this->report['senderName'],
                    //'msg' => $this->report['message'],
                ]);
    }
}
