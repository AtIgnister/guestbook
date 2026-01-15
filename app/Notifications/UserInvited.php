<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Invite;

class UserInvited extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $userRol, public User $sender, Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    //TODO: set up mail service 
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appName = env('APP_NAME');

        $url = route('register', ['token'=>$this->invite->id]);

        return (new MailMessage)
            ->subject("{$appName} Invitation")
            ->greeting('Hello!')
            ->line("You have been invited by {$this->sender->name} to join the {$appName} application!")
            ->action('Click here to register your account', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }


}
