<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyCodeLeapEmail extends Notification
{
    public function __construct(public string $code) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify your Code Leap email address')
            ->greeting('Welcome to Code Leap!')
            ->line('Thank you for creating your account.')
            ->line('Please verify your email address:')
            ->line("Your verification code is: {$this->code}")
            ->line('This code expires in 15 minutes.')
            ->line('If you did not create this account, you can safely ignore this email.');
    }
}
