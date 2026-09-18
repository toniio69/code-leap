<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class SocialiteController extends Controller
{
    protected array $supportedProviders = ['google'];

    public function redirect(string $provider)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        if (! in_array($provider, $this->supportedProviders, true)) {
            return redirect()->route('login')->with('error', 'Social login with '.$provider.' is not supported yet.');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        if (! in_array($provider, $this->supportedProviders, true)) {
            return redirect()->route('login')->with('error', 'Social login with '.$provider.' is not supported yet.');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->with('error', 'Social login session expired. Please try again.');
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'password' => bcrypt(Str::random(24)),
                'role' => 'student',
            ]
        );

        $role = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if ($role) {
            $user->syncRoles([$role->name]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}
