<?php

namespace App\Notifications;

use App\Mail\VerifyEmailMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): VerifyEmailMail
    {
        return new VerifyEmailMail($notifiable);
    }
}
