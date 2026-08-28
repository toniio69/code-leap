<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usersCount = User::query()->count();
        $coursesCount = Course::query()->count();
        $enrollmentsCount = Enrollment::query()->count();
        $materialsCount = CourseMaterial::query()->count();
        $recentAccounts = User::query()
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'coursesCount',
            'enrollmentsCount',
            'materialsCount',
            'recentAccounts'
        ));
    }
}