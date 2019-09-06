<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MassMailing extends Mailable
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

        return $this->markdown('emails.massMailing.mass-mailing-form')
                ->to($this->report['emailTo'])
                ->from($this->report['email'], $this->report['name'])
                ->replyTo($this->report['email'], $this->report['name'])
                ->subject($this->report['subject'])
                ->with([
                    'sender_name' => $this->report['name'],
                    'sender_email' => $this->report['email'],
                    'msg' => $this->report['message'],
                ]);
    }
}
