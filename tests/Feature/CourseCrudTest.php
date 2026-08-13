<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_create_course()
    {
        $instructor = User::factory()->role('instructor')->create();

        $this->actingAs($instructor)
            ->post(route('courses.store'), [
                'title' => 'Test Course',
                'description' => 'Description for test course',
            ])
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', [
            'title' => 'Test Course',
            'description' => 'Description for test course',
            'user_id' => $instructor->id,
        ]);
    }

    public function test_student_cannot_create_course()
    {
        $student = User::factory()->role('student')->create();

        $this->actingAs($student)
            ->post(route('courses.store'), [
                'title' => 'Bad Course',
                'description' => 'Should be forbidden',
            ])
            ->assertForbidden();
    }

    public function test_student_can_browse_courses_and_view_course_details()
    {
        $student = User::factory()->role('student')->create();
        $instructor = User::factory()->role('instructor')->create();

        $course = Course::create([
            'title' => 'Introduction to Laravel',
            'description' => 'Learn the fundamentals of Laravel.',
            'user_id' => $instructor->id,
        ]);

        $this->actingAs($student)
            ->get(route('courses.index'))
            ->assertOk()
            ->assertSee($course->title);

        $this->actingAs($student)
            ->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee($course->description)
            ->assertSee('Enroll in Course');
    }

    public function test_instructor_can_update_their_course()
    {
        $instructor = User::factory()->role('instructor')->create();

        $course = Course::create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'user_id' => $instructor->id,
        ]);

        $this->actingAs($instructor)
            ->put(route('courses.update', $course), [
                'title' => 'Updated Title',
                'description' => 'Updated description',
            ])
            ->assertRedirect(route('courses.show', $course));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ]);
    }

    public function test_instructor_can_delete_their_course()
    {
        $instructor = User::factory()->role('instructor')->create();

        $course = Course::create([
            'title' => 'To Delete',
            'description' => 'Will be deleted',
            'user_id' => $instructor->id,
        ]);

        $this->actingAs($instructor)
            ->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }
}
