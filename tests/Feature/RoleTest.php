<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Guard one route per role using the RoleMiddleware aliases registered
        // in bootstrap/app.php. The application exposes real admin/student
        // routes, but no real instructor-protected route yet, so each role is
        // exercised through an equivalent test route backed by the same alias.
        Route::middleware(['auth', 'admin'])->get('/roles/admin', fn () => 'admin-area');
        Route::middleware(['auth', 'instructor'])->get('/roles/instructor', fn () => 'instructor-area');
        Route::middleware(['auth', 'student'])->get('/roles/student', fn () => 'student-area');
    }

    public function test_admin_can_access_admin_route_only(): void
    {
        $admin = User::factory()->role('admin')->create();

        $this->actingAs($admin)->get('/roles/admin')->assertOk();
        $this->actingAs($admin)->get('/roles/instructor')->assertForbidden();
        $this->actingAs($admin)->get('/roles/student')->assertForbidden();
    }

    public function test_instructor_can_access_instructor_route_only(): void
    {
        $instructor = User::factory()->role('instructor')->create();

        $this->actingAs($instructor)->get('/roles/instructor')->assertOk();
        $this->actingAs($instructor)->get('/roles/admin')->assertForbidden();
        $this->actingAs($instructor)->get('/roles/student')->assertForbidden();
    }

    public function test_student_can_access_student_route_only(): void
    {
        $student = User::factory()->role('student')->create();

        $this->actingAs($student)->get('/roles/student')->assertOk();
        $this->actingAs($student)->get('/roles/admin')->assertForbidden();
        $this->actingAs($student)->get('/roles/instructor')->assertForbidden();
    }

    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $this->get('/roles/admin')->assertRedirect(route('login'));
        $this->get('/roles/instructor')->assertRedirect(route('login'));
        $this->get('/roles/student')->assertRedirect(route('login'));
    }
}
