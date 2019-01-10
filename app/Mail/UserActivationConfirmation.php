<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserActivationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The report instance.
     *
     * @var Report
     */
    protected $mailDatas;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailDatas)
    {
         $this->mailDatas = $mailDatas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->markdown('emails.user-activation-confirmation')
               ->to($this->mailDatas['email'])
               ->from('noreply@globalcalendar.com', 'Global CI Calendar')
               ->replyTo('noreply@globalcalendar.com', 'Global CI Calendar')
               ->subject($this->mailDatas['subject'])
               ->with([
                   'name' => $this->mailDatas['name'],
               ]);
    }
}
