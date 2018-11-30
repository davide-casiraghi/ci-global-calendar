<?php

/* Inspired by - https://medium.com/@sadhakbj/laravel-5-5-activate-account-after-registration-using-laravel-notification-fd5dc7fa05ad */

namespace App\Notifications;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredSuccessfully extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
         $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /** @var User $user */
        $user = $this->user;
        
        return (new MailMessage)
                    /*->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');*/
                    ->from(env('ADMIN_MAIL'))
                    ->subject('Successfully created new account')
                    ->greeting(sprintf('Hello %s', $user->name))
                    ->line('You have successfully registered to the CI Global Calendar. You will get a confirmation email when your account will be approved by the administrator.')
                    //->action('Click Here', route('activate.user', $user->activation_code))
                    ->line('Thank you for registering!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
