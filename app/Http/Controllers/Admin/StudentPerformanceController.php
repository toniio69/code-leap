<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentPerformanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function __invoke(): View
    {
        $students = User::where('role', 'student')
            ->withCount('enrolledCourses')
            ->withCount(['enrollments as completed_enrollments_count' => function ($query) {
                $query->where('completed', true);
            }])
            ->latest()
            ->paginate(20);

        $completionRate = \App\Models\Enrollment::where('completed', true)->count() / max(\App\Models\Enrollment::count(), 1) * 100;

        return view('Admin.student-performance', compact('students', 'completionRate'));
    }
}
