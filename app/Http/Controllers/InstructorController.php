<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function landing(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('instructor') && !$user->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }

        $courses = $user->courses()
            ->withCount(['students', 'materials', 'lessons'])
            ->latest()
            ->get();

        $totalStudents = $courses->sum('students_count');
        $totalMaterials = $courses->sum('materials_count');
        $totalLessons = $courses->sum('lessons_count');

        $recentEnrollments = \App\Models\Enrollment::whereHas('course', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['user', 'course'])->latest()->limit(5)->get();

        return view('instructor.landing', compact(
            'courses',
            'totalStudents',
            'totalMaterials',
            'totalLessons',
            'recentEnrollments'
        ));
    }
}