<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $resetCode)
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(config('app.name').' - Password reset request')
            ->greeting('Hello!')
            ->line('A password reset for the account associated with this email has been requested.')
            ->line('Please enter the code bellow in your password reset page')
            ->line($this->resetCode)
            ->line('If you did not request a password reset, please ignore this message.');
    }
}
