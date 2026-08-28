<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminController extends Controller
{
    public function index(): View
    {
        $users = User::query()->orderBy('name')->get();

        return view('Admin.users', compact('users'));
    }

    public function dashboard(): View
    {
        $usersCount = User::query()->count();
        $coursesCount = Course::query()->count();
        $enrollmentsCount = Enrollment::query()->count();
        $materialsCount = CourseMaterial::query()->count();
        $recentAccounts = User::query()
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('Admin.Dashboard', compact(
            'usersCount',
            'coursesCount',
            'enrollmentsCount',
            'materialsCount',
            'recentAccounts'
        ));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,instructor,student'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User role updated.');
    }

    public function analytics(): View
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

        $enrollmentsByDay = Enrollment::query()
            ->get(['created_at'])
            ->groupBy(function ($enrollment) {
                return $enrollment->created_at->toDateString();
            })
            ->map(function ($items) {
                return $items->count();
            });

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

    public function studentPerformance(): View
    {
        $students = User::where('role', 'student')
            ->withCount('enrolledCourses')
            ->withCount(['enrollments as completed_enrollments_count' => function ($query) {
                $query->where('completed', true);
            }])
            ->latest()
            ->paginate(20);

        $completionRate = Enrollment::where('completed', true)->count() / max(Enrollment::count(), 1) * 100;

        return view('Admin.student-performance', compact('students', 'completionRate'));
    }

    public function payments(Request $request): View
    {
        $query = Payment::with(['user', 'course']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $payments = $query->latest()->paginate(20);

        $summary = [
            'total' => Payment::count(),
            'success' => Payment::where('status', 'success')->count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'revenue' => Payment::where('status', 'success')->sum('amount'),
        ];

        return view('Admin.payments', compact('payments', 'summary'));
    }
}
