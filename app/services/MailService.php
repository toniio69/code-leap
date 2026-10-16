<?php

namespace App\Services;

use App\Models\EmailVerificationCode;
use App\Models\User;
use App\Notifications\ResetCodeLeapPassword;
use App\Notifications\VerifyCodeLeapEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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

    /**
     * Allocate (and auto-generate) a password reset token for the given user.
     *
     * Tokens are stored hashed by the broker, so an already-issued token can
     * never be recovered in plain form. Allocation therefore: (1) prunes
     * expired token rows, (2) reports whether the request is still inside the
     * throttle window, and (3) auto-generates a fresh token via the broker
     * otherwise. createToken() persists the hash and returns the plain token.
     *
     * @return array{token: string|null, throttled: bool}
     */
    public function allocatePasswordResetToken(User $user): array
    {
        $broker = Password::broker();
        $repository = $broker->getRepository();

        // Drop expired tokens so stale rows never accumulate.
        if (method_exists($repository, 'deleteExpired')) {
            $repository->deleteExpired();
        }

        // Inside the throttle window a plain token cannot be recovered, so we
        // report it as throttled and let the caller surface a wait message.
        if (method_exists($repository, 'recentlyCreatedToken')
            && $repository->recentlyCreatedToken($user)) {
            return ['token' => null, 'throttled' => true];
        }

        return ['token' => $broker->createToken($user), 'throttled' => false];
    }

    public function sendPasswordReset(User $user, ?string $token = null): bool
    {
        // Allow callers (e.g. Fortify) to pass an already-generated token.
        if ($token !== null) {
            $user->notify(new ResetCodeLeapPassword($token));

            return true;
        }

        $allocation = $this->allocatePasswordResetToken($user);

        if ($allocation['token'] === null) {
            return false;
        }

        $user->notify(new ResetCodeLeapPassword($allocation['token']));

        return true;
    }
}
