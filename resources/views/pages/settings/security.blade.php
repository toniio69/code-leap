<x-layouts.settings>
    <div class="p-6 space-y-8">
        <!-- Password Section -->
        <section>
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Password') }}</flux:heading>
                    <flux:subheading>{{ __('Ensure your account is using a long, random password to stay secure') }}</flux:subheading>
                </div>

                <form method="POST" wire:submit="updatePassword" class="space-y-4">
                    @csrf
                    <flux:field>
                        <flux:label for="current_password">{{ __('Current password') }}</flux:label>
                        <flux:input
                            id="current_password"
                            wire:model="current_password"
                            type="password"
                            required
                            autocomplete="current-password"
                            viewable
                            class="w-full"
                        />
                    </flux:field>

                    <flux:field>
                        <flux:label for="password">{{ __('New password') }}</flux:label>
                        <flux:input
                            id="password"
                            wire:model="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                            viewable
                            class="w-full"
                        />
                    </flux:field>

                    <flux:field>
                        <flux:label for="password_confirmation">{{ __('Confirm password') }}</flux:label>
                        <flux:input
                            id="password_confirmation"
                            wire:model="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                            viewable
                            class="w-full"
                        />
                    </flux:field>

                    <div class="flex justify-end pt-2">
                        <flux:button variant="primary" type="submit" data-test="update-password-button">
                            {{ __('Save Changes') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </section>

        @if ($canManageTwoFactor)
            <flux:separator />

            <!-- Two-Factor Authentication Section -->
            <section class="space-y-6" wire:cloak>
                <div>
                    <flux:heading size="lg">{{ __('Two-factor authentication') }}</flux:heading>
                    <flux:subheading>{{ __('Manage your two-factor authentication settings') }}</flux:subheading>
                </div>

                <div class="space-y-4">
                    @if ($twoFactorEnabled)
                        <div class="rounded-lg border bg-card p-4 space-y-4">
                            <div class="flex items-start gap-3">
                                <flux:icon.shield-check class="size-5 text-green-600 dark:text-green-400 shrink-0 mt-0.5" />
                                <div class="flex-1">
                                    <p class="text-sm">
                                        {{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <flux:button
                                    variant="danger"
                                    wire:click="disable"
                                >
                                    {{ __('Disable 2FA') }}
                                </flux:button>
                            </div>

                            <livewire:pages.settings.two-factor.recovery-codes :$requiresConfirmation />
                        </div>
                    @else
                        <div class="rounded-lg border bg-card p-4 space-y-4">
                            <div class="flex items-start gap-3">
                                <flux:icon.shield class="size-5 text-muted-foreground shrink-0 mt-0.5" />
                                <div class="flex-1">
                                    <p class="text-sm text-muted-foreground">
                                        {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                                    </p>
                                </div>
                            </div>

                            <flux:modal.trigger name="two-factor-setup-modal">
                                <flux:button
                                    variant="primary"
                                    wire:click="$dispatch('start-two-factor-setup')"
                                >
                                    {{ __('Enable 2FA') }}
                                </flux:button>
                            </flux:modal.trigger>

                            <livewire:pages.settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                        </div>
                    @endif
                </div>
            </section>
        @endif

        @if ($canManagePasskeys)
            <flux:separator />

            <!-- Passkeys Section -->
            <section class="space-y-6" wire:cloak>
                <div>
                    <flux:heading size="lg">{{ __('Passkeys') }}</flux:heading>
                    <flux:subheading>{{ __('Manage your passkeys for passwordless sign-in') }}</flux:subheading>
                </div>

                <div class="rounded-lg border bg-card overflow-hidden">
                    @forelse ($passkeys as $passkey)
                        <div class="flex items-center justify-between p-4 {{ ! $loop->last ? 'border-b' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-muted">
                                    <flux:icon.key class="size-5 text-muted-foreground" />
                                </div>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2.5">
                                        <p class="font-medium tracking-tight">{{ $passkey['name'] }}</p>
                                        @if ($passkey['authenticator'])
                                            <flux:badge size="sm">{{ $passkey['authenticator'] }}</flux:badge>
                                        @endif
                                    </div>
                                    <p class="text-muted-foreground text-xs">
                                        {{ __('Added :time', ['time' => $passkey['created_at_diff']]) }}
                                        @if ($passkey['last_used_at_diff'])
                                            <span class="opacity-50 mx-1">/</span>
                                            {{ __('Last used :time', ['time' => $passkey['last_used_at_diff']]) }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <flux:button
                                variant="ghost"
                                size="sm"
                                icon="trash"
                                icon:variant="outline"
                                wire:click="confirmDelete({{ $passkey['id'] }})"
                                class="text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50"
                            />
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-muted">
                                <flux:icon.key class="size-7 text-muted-foreground" />
                            </div>
                            <p class="font-medium">{{ __('No passkeys yet') }}</p>
                            <flux:text class="mt-1">{{ __('Add a passkey to sign in without a password') }}</flux:text>
                        </div>
                    @endforelse
                </div>

                <x-passkey-registration />
            </section>
        @endif

        <flux:modal
            name="delete-passkey-modal"
            class="max-w-md md:min-w-md"
            @close="closeDeleteModal"
            wire:model="showDeleteModal"
        >
            <div class="space-y-6">
                <div class="space-y-2">
                    <flux:heading size="lg">{{ __('Remove passkey') }}</flux:heading>
                    <flux:text>
                        {{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $deletingPasskeyName]) }}
                    </flux:text>
                </div>

                <div class="flex gap-3 justify-end">
                    <flux:button
                        variant="outline"
                        wire:click="closeDeleteModal"
                    >
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button
                        variant="danger"
                        wire:click="deletePasskey"
                    >
                        {{ __('Remove passkey') }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</x-layouts.settings>