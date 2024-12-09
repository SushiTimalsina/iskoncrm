<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OTPNotification extends Notification
{
    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your OTP Code')
                    ->line('Your OTP code is: ' . $this->otp)
                    ->line('The code is valid for 10 minutes.')
                    ->line('If you did not request this, please ignore this email.');
    }
}
