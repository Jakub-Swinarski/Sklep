<?php

namespace App\Notifications;

use App\Services\EmailVerificationService;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailAlternative extends VerifyEmail {
    protected function verificationUrl($notifiable)
    {
        $uuid = app(EmailVerificationService::class)->createAttempt($notifiable->id);

        return route('verification.verify', [
            'uuid' => $uuid
        ]);
    }
}
