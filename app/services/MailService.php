<?php

namespace App\Services;

use App\Models\EmailVerificationCode;
use App\Models\User;
use App\Notifications\NewsletterNotification;
use App\Notifications\ResetCodeLeapPassword;
use App\Notifications\VerifyCodeLeapEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MailService
{
    public function sendVerification(User $user): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($user, $code): void {
            $attributes = [
                'user_id' => $user->id,
                'code' => Hash::make($code),
                'expires_at' => now()->addMinutes(15),
                'used_at' => null,
            ];

            $existingCode = $user->emailVerificationCodes()
                ->whereNull('used_at')
                ->latest()
                ->lockForUpdate()
                ->first();

            if ($existingCode) {
                $existingCode->update($attributes);

                return;
            }

            $recycledCode = EmailVerificationCode::query()
                ->whereNotNull('used_at')
                ->oldest('used_at')
                ->lockForUpdate()
                ->first();

            if ($recycledCode) {
                $recycledCode->update($attributes);

                return;
            }

            EmailVerificationCode::create($attributes);
        });

        $user->notify(new VerifyCodeLeapEmail($code));
    }

    public function sendPasswordReset(User $user, ?string $token = null): void
    {
        $token ??= Password::broker()->createToken($user);

        $user->notify(new ResetCodeLeapPassword($token));
    }

    public function sendNewsletter(User $user, string $newsletter): void
    {
        $user->notify(new NewsletterNotification($newsletter));
    }
}
