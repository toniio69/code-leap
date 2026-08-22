<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Course $course): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('instructor') || $user->hasRole('admin');
    }

    public function update(
        User $user,
        Course $course
    ): bool {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('instructor')
            && $user->id === $course->user_id;
    }

    public function delete(
        User $user,
        Course $course
    ): bool {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasRole('instructor')
            && $user->id === $course->user_id;
    }

    public function viewContent(
        User $user,
        Course $course
    ): bool {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('instructor')
            && $user->id === $course->user_id) {
            return true;
        }

        return $user->hasRole('student')
            && $course->students()
                ->where('users.id', $user->id)
                ->exists();
    }
}
