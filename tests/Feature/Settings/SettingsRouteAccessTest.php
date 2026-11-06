<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SettingsRouteAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * URL or route name => expected redirect target (when access is denied).
     */
    public static function settingsPageProvider(): array
    {
        return [
            'dashboard redirect' => ['/settings'],
            'profile page' => ['profile.edit'],
            'appearance page' => ['appearance.edit'],
            'security page' => ['security.edit'],
        ];
    }

    // ---------------------------------------------------------------------
    // Positive cases
    // ---------------------------------------------------------------------

    public function test_verified_users_can_reach_each_settings_page(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $this->get('/settings')->assertRedirect(route('profile.edit'));

        $this->get(route('profile.edit'))->assertOk();

        $this->get(route('appearance.edit'))->assertOk(); 

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()])
            ->get(route('security.edit'))
            ->assertOk();
    }

    public function test_verified_user_with_fresh_password_confirmation_can_access_security_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()])
            ->get(route('security.edit'))
            ->assertOk();
    }

    public function test_verified_user_can_access_security_page_via_password_confirmation_flow(): void
    {
        $user = User::factory()->create();

        // Without confirmation the user is sent to password.confirm...
        $response = $this->actingAs($user)->get(route('security.edit'));
        $response->assertRedirect(route('password.confirm'));

        // ...and after confirming, they are sent back to the intended page.
        $this->actingAs($user)
            ->withSession([
                'auth.password_confirmed_at' => time(),
                'url.intended' => route('security.edit'),
            ])
            ->get(route('security.edit'))
            ->assertOk();
    }

    // ---------------------------------------------------------------------
    // Negative cases
    // ---------------------------------------------------------------------

    #[DataProvider('settingsPageProvider')]
    public function test_guests_are_redirected_to_login_for_all_settings_pages(string $page): void
    {
        $this->get($this->resolveUri($page))
            ->assertRedirect('/login');
    }

    #[DataProvider('settingsPageProvider')]
    public function test_guests_are_never_granted_access_even_with_forged_session_data(string $page): void
    {
        // A guest trying to fake password confirmation must still be blocked.
        $this->withSession(['auth.password_confirmed_at' => time()])
            ->get($this->resolveUri($page))
            ->assertRedirect('/login');
    }

    public function test_unverified_users_are_redirected_from_verified_only_settings_pages(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user);

        // Profile only requires auth, so unverified users are allowed here.
        $this->get(route('profile.edit'))->assertOk();

        $this->get(route('appearance.edit'))
            ->assertRedirect(route('verification.notice'));

        $this->get(route('security.edit'))
            ->assertRedirect(route('verification.notice'));
    }

    /**
     * Verification must take precedence over password confirmation:
     * an unverified user with valid confirmation data is still blocked.
     */
    public function test_unverified_user_cannot_bypass_verification_with_confirmed_password(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()])
            ->get(route('security.edit'))
            ->assertRedirect(route('verification.notice'));
    }

    public function test_unconfirmed_users_are_redirected_to_password_confirmation_for_security_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('security.edit'))
            ->assertRedirect(route('password.confirm'));
    }

    public function test_verified_user_without_password_confirmation_cannot_access_appearance_free_pages_other_than_security(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Only the security page sits behind password.confirm.
        $this->get(route('profile.edit'))->assertOk();
        $this->get(route('appearance.edit'))->assertOk();
    }

    // ---------------------------------------------------------------------
    // Edge cases
    // ---------------------------------------------------------------------

    public function test_password_confirmation_expires_after_configured_timeout(): void
    {
        $user = User::factory()->create();

        $timeout = config('auth.password_timeout');

        // Confirmed just inside the window: allowed.
        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time() - $timeout + 1])
            ->get(route('security.edit'))
            ->assertOk();

        // Confirmed just outside the window: redirected to confirm again.
        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time() - $timeout - 1])
            ->get(route('security.edit'))
            ->assertRedirect(route('password.confirm'));
    }

    public function test_stale_password_confirmation_is_not_accepted(): void
    {
        $user = User::factory()->create();

        $timeout = config('auth.password_timeout');

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => now()->subSeconds($timeout + 10)->timestamp])
            ->get(route('security.edit'))
            ->assertRedirect(route('password.confirm'));
    }

    public function test_settings_root_redirects_even_when_already_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/settings')
            ->assertRedirect(route('profile.edit'));
    }

    public function test_guest_hitting_settings_root_is_redirected_to_login_not_profile(): void
    {
        // The redirect route must not run for guests: auth comes first.
        $this->get('/settings')
            ->assertRedirect('/login')
            ->assertLocation('/login');
    }

    public function test_settings_redirect_target_is_a_reachable_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/settings');

        $response->assertRedirect(route('profile.edit'));

        $this->get($response->headers->get('Location'))->assertOk();
    }

    public function test_routes_resolve_to_expected_uris(): void
    {
        $this->assertSame('http://localhost/settings/profile', route('profile.edit'));
        $this->assertSame('http://localhost/settings/appearance', route('appearance.edit'));
        $this->assertSame('http://localhost/settings/security', route('security.edit'));
    }

    public function test_verifying_email_mid_session_grants_access_to_verified_pages(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('appearance.edit'))
            ->assertRedirect(route('verification.notice'));

        // Mark the user verified (simulating completed verification)...
        $user->forceFill(['email_verified_at' => now()])->save();

        // ...without re-authenticating: the auth check reads the user per request.
        $this->get(route('appearance.edit'))->assertOk();
    }

    public function test_freshly_verified_user_still_needs_password_confirmation_for_security(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()])
            ->get(route('security.edit'))
            ->assertOk();

        // Confirmation is per-session, not persisted on the user record:
        // clearing the session value revokes access again.
        $this->withSession(['auth.password_confirmed_at' => null])
            ->get(route('security.edit'))
            ->assertRedirect(route('password.confirm'));
    }

    /**
     * Resolve a provider entry to a requestable URI.
     */
    private function resolveUri(string $page): string
    {
        return str_contains($page, '.') ? route($page) : $page;
    }
}
