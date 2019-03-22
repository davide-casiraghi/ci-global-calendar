<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactOrganizer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The message instance.
     *
     * @var Report
     */
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact.organizer')
            ->from($this->message['senderEmail'], $this->message['senderName'])
            ->replyTo($this->message['senderEmail'], $this->message['senderName'])
            ->subject($this->message['subject'])
            ->with([
                'event_title' => $this->message['event_title'],
                'event_id' => $this->message['event_id'],
                'msg' => $this->message['message'],
                'sender_email' => $this->message['senderEmail'],
                'sender_name' => $this->message['senderName'],
                'subject' => $this->message['subject'],
            ]);
    }
}
