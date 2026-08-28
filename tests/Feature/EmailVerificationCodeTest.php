<?php

namespace Tests\Feature;

use App\Models\EmailVerificationCode;
use App\Models\User;
use App\Notifications\VerifyCodeLeapEmail;
use App\Services\MailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_verify_their_email_with_a_valid_six_digit_code(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();

        app(MailService::class)->sendVerification($user);

        $code = $this->verificationCodeFromNotification($user);

        $this->actingAs($user)
            ->post(route('verification.code.verify'), ['code' => $code])
            ->assertRedirect(route('dashboard'));

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertNotNull(EmailVerificationCode::first(['used_at'])->used_at);
    }

    public function test_used_verification_code_record_is_recycled_for_a_new_user(): void
    {
        Notification::fake();
        $firstUser = User::factory()->unverified()->create();

        app(MailService::class)->sendVerification($firstUser);
        $firstCode = $this->verificationCodeFromNotification($firstUser);

        $this->actingAs($firstUser)
            ->post(route('verification.code.verify'), ['code' => $firstCode]);

        $codeRecord = EmailVerificationCode::where('user_id', $firstUser->id)->first(['id']);
        $codeRecordId = $codeRecord->id;
        $secondUser = User::factory()->unverified()->create();

        app(MailService::class)->sendVerification($secondUser);

        $this->assertDatabaseCount('email_verification_codes', 1);
        $this->assertDatabaseHas('email_verification_codes', [
            'id' => $codeRecordId,
            'user_id' => $secondUser->id,
            'used_at' => null,
        ]);
    }

    public function test_expired_verification_code_cannot_verify_an_account(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();

        app(MailService::class)->sendVerification($user);
        $code = $this->verificationCodeFromNotification($user);
        EmailVerificationCode::where('user_id', $user->id)->first()->update(['expires_at' => now()->subMinute()]);

        $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.code.verify'), ['code' => $code])
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHasErrors('code');

        $this->assertNull($user->fresh()->email_verified_at);
    }

    private function verificationCodeFromNotification(User $user): string
    {
        $code = '';

        Notification::assertSentTo(
            $user,
            VerifyCodeLeapEmail::class,
            function (VerifyCodeLeapEmail $notification) use (&$code): bool {
                $code = $notification->code;

                return true;
            }
        );

        return $code;
    }
}
