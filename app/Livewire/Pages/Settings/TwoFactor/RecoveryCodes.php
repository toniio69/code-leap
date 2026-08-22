<?php

namespace App\Livewire\Pages\Settings\TwoFactor;

use Illuminate\Contracts\View\View;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Component;

class RecoveryCodes extends Component
{
    /** @var array<int, string> */
    public array $recoveryCodes = [];

    public function mount(): void
    {
        $this->loadRecoveryCodes();
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generateNewRecoveryCodes): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $generateNewRecoveryCodes($user);

        $this->loadRecoveryCodes();
    }

    private function loadRecoveryCodes(): void
    {
        $user = auth()->user();

        if (! $user || ! $user->hasEnabledTwoFactorAuthentication() || ! $user->two_factor_recovery_codes) {
            $this->recoveryCodes = [];

            return;
        }

        try {
            $this->recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
        } catch (\Exception) {
            $this->addError('recoveryCodes', 'Failed to load recovery codes');

            $this->recoveryCodes = [];
        }
    }

    public function render(): View
    {
        return view('pages.settings.two-factor.recovery-codes');
    }
}
