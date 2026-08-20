<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\ResetCodeLeapPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\TestCase;

class DebugPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skipUnlessFortifyHas(Features::resetPasswords());
    }

    public function test_debug_password_reset(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'debug@example.com']);

        try {
            $response = $this->post(route('password.request'), ['email' => $user->email]);
        } catch (\Throwable $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            echo "Trace: " . $e->getTraceAsString() . "\n";
            return;
        }

        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Content: " . $response->getContent() . "\n";

        $sent = Notification::sentNotifications();
        echo "Sent count: " . count($sent) . "\n";
        foreach ($sent as $notification) {
            echo "Notification: " . get_class($notification) . "\n";
            echo "To: " . ($notification->notifiable->email ?? 'unknown') . "\n";
        }
    }
}
