<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') - {{ config('app.name', 'Code Leap') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @stack('styles')
</head>
<body class="min-h-screen bg-background text-foreground antialiased selection:bg-primary selection:text-primary-foreground">
    <div class="flex min-h-screen w-full">
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-xs md:hidden"></div>

        <!-- Sidebar -->
        <aside id="app-sidebar" class="fixed inset-y-0 left-0 z-50 hidden w-64 shrink-0 flex-col border-r border-border bg-card text-card-foreground shadow-sm transition-all duration-200 md:static md:flex">
            <!-- Brand / Logo -->
            <div class="flex h-16 items-center gap-3 border-b border-border px-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <x-app-logo sidebar="true" class="h-8 w-auto" />
                    <span class="text-base font-bold tracking-tight text-foreground">{{ config('app.name', 'Code Leap') }}</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 space-y-6 overflow-y-auto p-4">
                <div>
                    <p class="px-2 mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Learning</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') || request()->routeIs('student.dashboard') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses.index') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('courses.*') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                                Course Catalog
                            </a>
                        </li>
                    </ul>
                </div>

                @if(auth()->check() && (auth()->user()->hasRole('instructor') || auth()->user()->hasRole('admin')))
                <div>
                    <p class="px-2 mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Instructor</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('instructor.dashboard') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                Instructor Space
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses.create') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('courses.create') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                Create Course
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('instructor.certificates.index') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('instructor.certificates.*') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                                Certificates
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

                @if(auth()->check() && auth()->user()->hasRole('admin'))
                <div>
                    <p class="px-2 mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Admin Portal</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                                Overview
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('admin.analytics') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                                Analytics
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payments') }}" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('admin.payments') ? 'bg-accent text-accent-foreground font-semibold' : 'text-muted-foreground hover:bg-accent/60 hover:text-foreground' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                Payments
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </nav>

            <!-- User Menu Footer -->
            @auth
            <div class="border-t border-border p-3">
                <details class="group relative">
                    <summary class="flex h-10 w-full cursor-pointer items-center gap-3 rounded-md px-2 py-1 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground list-none focus:outline-none">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-xs font-semibold text-primary">
                            {{ auth()->user()->initials() }}
                        </div>
                        <div class="flex-1 min-w-0 text-left">
                            <p class="truncate text-xs font-semibold text-foreground">{{ auth()->user()->name }}</p>
                            <p class="truncate text-[11px] text-muted-foreground capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <svg class="h-4 w-4 text-muted-foreground transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </summary>
                    <div class="mt-2 space-y-1 rounded-lg border border-border bg-card p-1.5 shadow-md">
                        <p class="px-2 py-1 text-[11px] text-muted-foreground truncate">{{ auth()->user()->email }}</p>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-md px-2 py-1.5 text-xs text-foreground transition-colors hover:bg-accent">
                            Settings & Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-xs font-medium text-destructive transition-colors hover:bg-destructive/10">
                                Log out
                            </button>
                        </form>
                    </div>
                </details>
            </div>
            @endauth
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-1 flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-border bg-background/95 px-4 backdrop-blur supports-[backdrop-filter]:bg-background/60 sm:px-6">
                <button id="sidebar-toggle" aria-label="Toggle navigation" class="md:hidden flex h-9 w-9 items-center justify-center rounded-md border border-input bg-background text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>

                <div class="flex items-center gap-2 text-sm font-medium text-muted-foreground">
                    <span class="text-foreground font-semibold capitalize">{{ request()->segment(1) ?: 'Home' }}</span>
                    @if(request()->segment(2))
                        <span class="text-muted-foreground">/</span>
                        <span class="capitalize">{{ request()->segment(2) }}</span>
                    @endif
                </div>

                <div class="ml-auto flex items-center gap-3">
                    <a href="{{ route('courses.index') }}" class="hidden sm:inline-flex items-center justify-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium text-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                        Browse Courses
                    </a>

                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                            @csrf
                            <button type="submit" class="inline-flex h-9 items-center justify-center rounded-md bg-secondary px-3.5 py-1.5 text-xs font-medium text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-medium text-primary-foreground transition-colors hover:bg-primary/90">
                            Sign In
                        </a>
                    @endauth
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-border bg-card px-6 py-4 text-xs text-muted-foreground">
                <div class="mx-auto flex max-w-7xl flex-col sm:flex-row items-center justify-between gap-2">
                    <p>© {{ date('Y') }} {{ config('app.name', 'Code Leap') }}. All rights reserved.</p>
                    <p class="text-muted-foreground">E-Learning Platform for Modern Developers</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        (function() {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('app-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            function toggleSidebar() {
                if (!sidebar) return;
                const isHidden = sidebar.classList.contains('hidden');
                if (isHidden) {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('flex');
                    backdrop?.classList.remove('hidden');
                } else {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex');
                    backdrop?.classList.add('hidden');
                }
            }

            toggleBtn?.addEventListener('click', toggleSidebar);
            backdrop?.addEventListener('click', toggleSidebar);
        })();
    </script>
    @stack('scripts')
</body>
</html>

