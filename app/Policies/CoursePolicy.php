<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Any authenticated user can browse the course catalogue.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Course details are public to authenticated users. Access to learning
     * materials continues to be controlled by viewContent().
     */
    public function view(User $user, Course $course): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'instructor';
    }

    public function update(
        User $user,
        Course $course
    ): bool {
        return $user->role === 'instructor'
            && $user->id === $course->user_id;
    }

    public function delete(
        User $user,
        Course $course
    ): bool {
        return $user->role === 'instructor'
            && $user->id === $course->user_id;
    }

    public function viewContent(
        User $user,
        Course $course
    ): bool {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'instructor'
            && $user->id === $course->user_id) {
            return true;
        }

        return $user->role === 'student'
            && $course->students()
                ->where('users.id', $user->id)
                ->exists();
    }
}
