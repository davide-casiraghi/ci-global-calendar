<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserActivationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The report instance.
     *
     * @var array
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
               ->to($this->mailDatas['emailTo'])
               ->from('noreply@globalcalendar.com', 'noReply - Global CI Calendar')
               ->replyTo('noreply@globalcalendar.com', 'noReply - CI Calendar')
               ->subject($this->mailDatas['subject'])
               ->with([
                   'name' => $this->mailDatas['name'],
               ]);
    }
}
