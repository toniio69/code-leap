<?php

namespace App\Providers;

use App\Livewire\Pages\Settings\Appearance;
use App\Livewire\Pages\Settings\DeleteUserForm;
use App\Livewire\Pages\Settings\DeleteUserModal;
use App\Livewire\Pages\Settings\Profile;
use App\Livewire\Pages\Settings\Security;
use App\Livewire\Pages\Settings\TwoFactor\RecoveryCodes;
use App\Livewire\Pages\Settings\TwoFactorSetupModal;
use App\Models\Course;
use App\Policies\CoursePolicy;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);

        Blade::anonymousComponentNamespace('layouts');
        Blade::anonymousComponentNamespace('pages');

        Livewire::component('pages::settings.profile', Profile::class);
        Livewire::component('pages::settings.security', Security::class);
        Livewire::component('pages::settings.delete-user-modal', DeleteUserModal::class);
        Livewire::component('pages::settings.delete-user-form', DeleteUserForm::class);
        Livewire::component('pages::settings.two-factor-setup-modal', TwoFactorSetupModal::class);
        Livewire::component('pages::settings.two-factor.recovery-codes', RecoveryCodes::class);
        Livewire::component('pages::settings.appearance', Appearance::class);

        $this->configureDefaults();
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
