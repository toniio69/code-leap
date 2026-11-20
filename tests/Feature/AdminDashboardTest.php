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
        /** @var User $admin */
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
        /** @var User $admin */
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

    public function test_guests_cannot_access_the_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_users_cannot_access_the_admin_dashboard(): void
    {
        $user = User::factory()->role('student')->create();
        $user->assignRole('student');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_dashboard_only_shows_the_five_most_recent_accounts(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $admin->assignRole('admin');

        User::factory()->count(7)->create(['name' => 'Bulk User']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('recentAccounts', function ($recentAccounts) {
            return $recentAccounts->count() === 5;
        });
    }

    public function test_admin_dashboard_passes_counts_to_the_view(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('usersCount', 1);
        $response->assertViewHas('coursesCount', 0);
        $response->assertViewHas('enrollmentsCount', 0);
        $response->assertViewHas('materialsCount', 0);
    }

    public function test_guests_cannot_access_the_student_dashboard(): void
    {
        $response = $this->get(route('student.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_students_cannot_access_the_student_dashboard(): void
    {
        $instructor = User::factory()->role('instructor')->create();
        $instructor->assignRole('instructor');

        $response = $this->actingAs($instructor)->get(route('student.dashboard'));

        $response->assertForbidden();
    }
}
