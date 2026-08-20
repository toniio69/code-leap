<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function __invoke(): View
    {
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::where('completed', true)->count();
        $totalPayments = Payment::where('status', 'success')->sum('amount');
        $recentPayments = Payment::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        $topCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(10)
            ->get();

        $enrollmentsByDay = Enrollment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->take(30)
            ->get();

        return view('Admin.analytics', compact(
            'totalCourses',
            'totalEnrollments',
            'completedEnrollments',
            'totalPayments',
            'recentPayments',
            'topCourses',
            'enrollmentsByDay'
        ));
    }
}
