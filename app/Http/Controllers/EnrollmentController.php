<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user->role === 'student', 403);

        if ($course->price > 0) {
            return redirect()->route('paystack.pay', $course)->with('error', 'This is a premium course. Complete payment to enroll.');
        }

        $course->students()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'You have successfully enrolled.');
    }
}
