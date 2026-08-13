<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_can_be_rendered(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_dashboard_page_can_be_rendered_for_authenticated_user(): void
    {
        $user = User::factory()->role('student')->create();

        $response = $this->actingAs($user)->get(route('student.dashboard'));

        $response->assertOk();
        $response->assertSee('Dashboard');
    }

    public function test_admin_dashboard_shows_recent_account_creations_from_database(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $recentUser = User::factory()->create([
            'name' => 'Recent Signup',
            'email' => 'recent@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Recent Account Creations');
        $response->assertSee('Recent Signup');
        $response->assertSee('recent@example.com');
    }
}
