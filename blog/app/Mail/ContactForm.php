<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactForm extends Mailable
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

         return $this
                ->to($this->report['emailTo'])
                ->from($this->report['email'])
                ->subject($this->report['subject'])
                ->view('emails.contactform')
                ->with([
                    'name' => $this->report['name'],
                    'msg' => $this->report['message']
                ]);
     }
}
