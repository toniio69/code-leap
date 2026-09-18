<x-components.layouts.app>
    <x-slot name="heading">
        <flux:heading>{{ __('Settings') }}</flux:heading>
    </x-slot>

    <div class="flex min-h-[calc(100vh-4rem)]">
        <!-- Sidebar Navigation -->
        <aside class="hidden lg:block w-64 shrink-0 border-r bg-card">
            <nav class="p-4 space-y-1" aria-label="Settings navigation">
                <a
                    href="{{ route('profile.edit') }}"
                    wire:navigate.hover
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('profile.edit') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground' }}"
                >
                    <flux:icon.user class="size-4" />
                    {{ __('Profile') }}
                </a>

                <a
                    href="{{ route('security.edit') }}"
                    wire:navigate.hover
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('security.edit') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground' }}"
                >
                    <flux:icon.shield class="size-4" />
                    {{ __('Security') }}
                </a>

                <a
                    href="{{ route('appearance.edit') }}"
                    wire:navigate.hover
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('appearance.edit') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground' }}"
                >
                    <flux:icon.palette class="size-4" />
                    {{ __('Appearance') }}
                </a>

                @if (auth()->user()->hasRole('instructor'))
                    <a
                        href="{{ route('instructor.certificates.index') }}"
                        wire:navigate.hover
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('instructor.certificates*') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground' }}"
                    >
                        <flux:icon.award class="size-4" />
                        {{ __('Certificates') }}
                    </a>
                @endif

                @if (auth()->user()->hasRole('admin'))
                    <hr class="my-2 border-border" />
                    <a
                        href="{{ route('admin.dashboard') }}"
                        wire:navigate.hover
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground text-muted-foreground"
                    >
                        <flux:icon.layout-dashboard class="size-4" />
                        {{ __('Admin Dashboard') }}
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Mobile Tabs -->
        <div class="lg:hidden border-b bg-card">
            <div class="flex overflow-x-auto px-4 py-2" role="tablist">
                <button
                    wire:navigate.hover
                    href="{{ route('profile.edit') }}"
                    role="tab"
                    class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('profile.edit') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}"
                >
                    {{ __('Profile') }}
                </button>
                <button
                    wire:navigate.hover
                    href="{{ route('security.edit') }}"
                    role="tab"
                    class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('security.edit') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}"
                >
                    {{ __('Security') }}
                </button>
                <button
                    wire:navigate.hover
                    href="{{ route('appearance.edit') }}"
                    role="tab"
                    class="whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('appearance.edit') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}"
                >
                    {{ __('Appearance') }}
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6 lg:p-8">
            <div class="mx-auto max-w-3xl space-y-8">
                <!-- Profile Header Card -->
                <div class="rounded-xl border bg-card p-6">
                    <div class="flex flex-col items-center gap-4 text-center sm:flex-row sm:items-start sm:text-left">
                        <div class="relative shrink-0">
                            <flux:avatar class="size-20">
                                <flux:avatar.image
                                    :src="auth()->user()->profile_photo_url ?? null"
                                    :alt="auth()->user()->name"
                                />
                                <flux:avatar.fallback>{{ auth()->user()->initials() }}</flux:avatar.fallback>
                            </flux:avatar>

                            <label
                                for="profile-photo-upload"
                                class="absolute bottom-0 right-0 rounded-full bg-primary p-1.5 text-primary-foreground shadow-lg hover:bg-primary/90 transition-colors cursor-pointer"
                                title="{{ __('Change photo') }}"
                            >
                                <flux:icon.camera class="size-4" />
                                <input
                                    id="profile-photo-upload"
                                    type="file"
                                    accept="image/*"
                                    class="sr-only"
                                    wire:change="updateProfilePhoto"
                                >
                            </label>
                        </div>

                        <div class="flex-1 space-y-2">
                            <div>
                                <h2 class="text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h2>
                                <p class="text-muted-foreground">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <flux:badge variant="{{ auth()->user()->hasRole('admin') ? 'default' : (auth()->user()->hasRole('instructor') ? 'secondary' : 'outline') }}">
                                    {{ ucfirst(auth()->user()->role) }}
                                </flux:badge>

                                @if (auth()->user()->email_verified_at)
                                    <flux:badge variant="outline" class="text-green-600 dark:text-green-400 border-green-200 dark:border-green-800">
                                        <flux:icon.check class="size-3 mr-1" /> {{ __('Verified') }}
                                    </flux:badge>
                                @else
                                    <flux:badge variant="outline" class="text-yellow-600 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800">
                                        <flux:icon.alert-circle class="size-3 mr-1" /> {{ __('Unverified') }}
                                    </flux:badge>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="rounded-xl border bg-card">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</x-components.layouts.app>