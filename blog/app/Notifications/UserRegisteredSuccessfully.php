<?php

/* Inspired by - https://medium.com/@sadhakbj/laravel-5-5-activate-account-after-registration-using-laravel-notification-fd5dc7fa05ad */

namespace App\Notifications;

use App\User;
use App\Country;

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
        $countries = Country::pluck('name', 'id');

        /** @var User $user */
        $user = $this->user;
        
        return (new MailMessage)
                    ->from(env('ADMIN_MAIL'))
                    ->subject('New user registration')
                    ->greeting('Hello administrator')
                    ->line('A new user has registered on the CI Global calendar website.')
                    ->line(sprintf('Name: %s', $user->name))
                    ->line(sprintf('Email: %s', $user->email))
                    ->line(sprintf('Country: %s', $countries[$user->country_id]))
                    ->line(sprintf('Description: %s', $user->description))
                    ->action('Activate user', route('activate.user', $user->activation_code));
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
