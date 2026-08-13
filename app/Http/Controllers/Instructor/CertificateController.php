<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:instructor']);
    }

    public function index(): View
    {
        $courses = Course::where('user_id', auth()->id())->get();

        $pendingCertificates = Certificate::whereIn('course_id', $courses->pluck('id'))
            ->where('status', 'pending')
            ->with(['user', 'course'])
            ->latest()
            ->get();

        $issuedCertificates = Certificate::whereIn('course_id', $courses->pluck('id'))
            ->where('status', 'issued')
            ->with(['user', 'course'])
            ->latest()
            ->get();

        return view('Instructor.certificates.index', compact('courses', 'pendingCertificates', 'issuedCertificates'));
    }

    public function issue(Request $request, Certificate $certificate): \Illuminate\Http\RedirectResponse
    {
        $course = $certificate->course;

        abort_if($course->user_id !== auth()->id(), 403);

        $certificate->update([
            'status' => 'issued',
            'issued_by' => auth()->id(),
            'issued_at' => now(),
        ]);

        return back()->with('success', 'Certificate issued successfully.');
    }
}
