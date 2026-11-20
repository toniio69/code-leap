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

        abort_unless($user->hasRole('student'), 403);

        if ($course->price > 0) {
            abort_unless($user->hasPermissionTo('enroll in premium courses'), 403);

            return redirect()->route('paystack.pay', $course)->with('error', 'This is a premium course. Complete payment to enroll.');
        }

        abort_unless($user->hasPermissionTo('enroll in free courses'), 403);

        $course->students()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'You have successfully enrolled.');
    }
}
