<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = $request->user();

            abort_unless($user->hasRole('admin'), 403);

            return $next($request);
        });
    }

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
}
