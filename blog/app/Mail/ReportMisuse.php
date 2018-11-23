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
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
         return $this->from($this->event->senderEmail, $this->event->senderName)->subject($this->event->subject)->to($this->event->email)->markdown('emails.emailToEnrollee')->with([
                 'message' => $this->event->message,
                 'sender' => $this->event->senderName,
                 'subject' => $this->event->subject,
             ]);
     }
}
