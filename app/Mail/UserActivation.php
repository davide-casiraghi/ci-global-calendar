<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserActivation extends Mailable
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
        // Configure email parameters in .env file

        return $this->markdown('emails.user-activation')
                ->to(env('ADMIN_MAIL'))
                ->from('noreply@globalcalendar.com', 'Global CI Calendar')
                ->replyTo('noreply@globalcalendar.com', 'Global CI Calendar')
                ->subject($this->mailDatas['subject'])
                ->with([
                    'name' => $this->mailDatas['name'],
                    'email' => $this->mailDatas['email'],
                    'country' => $this->mailDatas['country'],
                    'description' => $this->mailDatas['description'],
                    'activation_code' => $this->mailDatas['activation_code'],
                ]);
    }
}
