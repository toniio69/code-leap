<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetCodeLeapPassword extends Notification
{
    public function __construct(public string $token) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Reset your Code Leap password')
            ->greeting('Password Reset Request')
            ->line('We received a request to reset your Code Leap password.')
            ->action('Reset Password', $resetUrl)
            ->line('This link will expire after a limited period.')
            ->line('If you did not request this, you can ignore this email.');
    }
}
