<x-layouts.settings>
    <form wire:submit="updateProfileInformation" class="p-6 space-y-6">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Profile Information') }}</flux:heading>
                <flux:subheading>{{ __('Update your name and email address') }}</flux:subheading>
            </div>

            <flux:field>
                <flux:label for="name">{{ __('Name') }}</flux:label>
                <flux:input
                    id="name"
                    wire:model="name"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full"
                />
            </flux:field>

            <flux:field>
                <flux:label for="email">{{ __('Email') }}</flux:label>
                <flux:input
                    id="email"
                    wire:model="email"
                    type="email"
                    required
                    autocomplete="email"
                    class="w-full"
                />
            </flux:field>

            @if ($this->hasUnverifiedEmail)
                <div class="rounded-lg border bg-yellow-50 p-4 dark:bg-yellow-900/20">
                    <div class="flex items-center gap-3">
                        <flux:icon.alert-circle class="size-5 text-yellow-600 dark:text-yellow-400 shrink-0" />
                        <div>
                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ __('Your email address is unverified.') }}
                            </p>
                            <flux:link class="text-sm cursor-pointer mt-1" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </div>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 flex items-center gap-2 text-sm text-green-700 dark:text-green-300">
                            <flux:icon.check-circle class="size-4" />
                            <span>{{ __('A new verification link has been sent to your email address.') }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end gap-3 border-t pt-6">
            <flux:button variant="primary" type="submit" data-test="update-profile-button">
                {{ __('Save Changes') }}
            </flux:button>
        </div>
    </form>

    @if ($this->showDeleteUser)
        <livewire:pages::settings.delete-user-form />
    @endif
</x-layouts.settings>