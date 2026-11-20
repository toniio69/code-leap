<?php

namespace App\Http\Controllers;

use App\Models\EdxCourse;
use App\Services\EdxSyncService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EdxCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $organization = $request->query('organization');

        $courses = EdxCourse::query()
            ->when($search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('organization', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($organization, fn ($q, $org) => $q->where('organization', $org))
            ->latest()
            ->paginate(12)
            ->withPath(request()->url());

        $organizations = EdxCourse::distinct()->pluck('organization')->filter()->sort()->values();

        return view('edx.courses.index', compact('courses', 'search', 'organization', 'organizations'));
    }

    public function show(string $edxId): View
    {
        $course = EdxCourse::where('edx_id', $edxId)->firstOrFail();

        return view('edx.courses.show', compact('course'));
    }

    public function sync(Request $request, EdxSyncService $syncService): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        if (! $user->hasRole('admin') && ! $user->hasRole('instructor')) {
            abort(403);
        }

        $stats = $syncService->sync();

        return back()->with('success', "Synced {$stats['created']} new courses, updated {$stats['updated']} courses.");
    }
}
