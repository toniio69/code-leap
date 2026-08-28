<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'instructor', 'guard_name' => 'web']);
        Role::create(['name' => 'student', 'guard_name' => 'web']);
    }

    public function test_admin_dashboard_can_be_rendered(): void
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_dashboard_page_can_be_rendered_for_authenticated_user(): void
    {
        $user = User::factory()->role('student')->create();
        $user->assignRole('student');

        $response = $this->actingAs($user)->get(route('student.dashboard'));

        $response->assertOk();
        $response->assertSee('Dashboard');
    }

    public function test_admin_dashboard_shows_recent_account_creations_from_database(): void
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        $recentUser = User::factory()->create([
            'name' => 'Recent Signup',
            'email' => 'recent@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Recent Signup');
    }
}
