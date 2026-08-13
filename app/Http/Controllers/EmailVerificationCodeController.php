<?php

namespace App\Http\Controllers;

use App\Models\EmailVerificationCode;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmailVerificationCodeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'regex:/^\d{6}$/'],
        ]);

        $user = $request->user();

        $verificationCode = EmailVerificationCode::query()
            ->where('user_id', $user->id)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->get()
            ->first(fn (EmailVerificationCode $record): bool => Hash::check(
                $validated['code'],
                $record->code
            ));

        if (! $verificationCode) {
            return back()
                ->withInput()
                ->withErrors(['code' => 'The verification code is invalid or has expired.']);
        }

        $verificationCode->update(['used_at' => now()]);

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect()->route('dashboard')->with('status', 'Email verified successfully.');
    }
}
