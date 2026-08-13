<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_students_are_routed_to_the_student_dashboard(): void
    {
        $user = User::factory()->role('student')->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('student.dashboard'));
    }

    public function test_instructors_are_routed_to_the_instructor_dashboard(): void
    {
        $instructor = User::factory()->role('instructor')->create();

        $response = $this->actingAs($instructor)->get(route('dashboard'));

        $response->assertRedirect(route('instructor.dashboard'));
    }

    public function test_admins_are_routed_to_the_admin_dashboard(): void
    {
        $admin = User::factory()->role('admin')->create();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertRedirect(route('admin.dashboard'));
    }
}
