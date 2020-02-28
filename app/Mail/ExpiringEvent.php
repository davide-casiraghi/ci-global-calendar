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
                ->from($this->report['email'], $this->report['name'])
                ->replyTo($this->report['email'], $this->report['name'])
                ->subject($this->report['subject'])
                ->with([
                    'user_name' => $this->report['name'],
                    'event_title' => $this->report['email'],
                    'msg' => $this->report['message'],
                ]);
    }
}
