<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') - {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="bg-background text-foreground antialiased">
    <div class="flex min-h-screen w-full">
        <aside id="app-sidebar" class="hidden w-64 shrink-0 border-r border-border bg-background md:block">
            <div class="flex h-16 items-center gap-2 px-6">
                <img src="{{ asset('Code Leap logo.png') }}" alt="Code Leap" class="h-8 w-auto">
                <span class="text-lg font-bold tracking-wider">{{ config('app.name') }}</span>
            </div>

            <nav class="flex-1 overflow-y-auto p-4">
                <div class="space-y-6">
                    <div>
                        <p class="px-2 mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Workspace</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-md px-2 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-accent text-accent-foreground' : 'text-foreground hover:bg-accent hover:text-accent-foreground' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('courses.index') }}" class="flex items-center gap-3 rounded-md px-2 py-2 text-sm font-medium transition-colors {{ request()->routeIs('courses.*') ? 'bg-accent text-accent-foreground' : 'text-foreground hover:bg-accent hover:text-accent-foreground' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                                    Courses
                                </a>
                            </li>
                        </ul>
                    </div>

                    @if(auth()->user()->hasRole('admin'))
                    <div>
                        <p class="px-2 mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Platform</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-md px-2 py-2 text-sm font-medium transition-colors {{ request()->routeIs('admin.*') ? 'bg-accent text-accent-foreground' : 'text-foreground hover:bg-accent hover:text-accent-foreground' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    Admin
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>

                <div class="mt-6 md:hidden">
                    <input type="search" placeholder="Search…" aria-label="Search workspace" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                </div>
            </nav>

            <div class="border-t border-border p-4">
                <details class="group">
                    <summary class="flex h-9 w-full cursor-pointer items-center gap-3 rounded-md px-2 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground list-none">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-xs font-medium text-primary">
                            {{ auth()->user()->initials() }}
                        </div>
                        <span class="flex-1 truncate">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4 text-muted-foreground transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                    </summary>
                    <div class="mt-1 space-y-1 pl-9">
                        <p class="text-xs text-muted-foreground truncate">{{ auth()->user()->email }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-sm text-red-600 transition-colors hover:bg-red-50 hover:text-red-700">
                                Log out
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        </aside>

        <div class="flex flex-1 flex-col">
            <header class="sticky top-0 z-10 flex h-14 items-center gap-3 border-b border-border bg-background/80 px-4 backdrop-blur sm:px-6">
                <button id="sidebar-toggle" class="md:hidden flex h-9 w-9 items-center justify-center rounded-md border border-input bg-background text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>

                <div class="hidden md:flex items-center gap-2 text-sm text-muted-foreground">
                    <span class="capitalize">{{ request()->segment(1) ?: 'Home' }}</span>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    <div class="hidden md:block w-56">
                        <input type="search" placeholder="Search…" aria-label="Search workspace" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                    </div>

                    <button type="button" class="relative flex h-9 w-9 items-center justify-center rounded-md border border-input bg-background text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        <span class="absolute end-1.5 top-1.5 size-1.5 rounded-full bg-foreground"></span>
                        <span class="sr-only">Notifications</span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                        @csrf
                        <button type="submit" class="inline-flex h-9 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('app-sidebar');
            if (!sidebar) return;
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-y-0');
            sidebar.classList.toggle('left-0');
            sidebar.classList.toggle('z-50');
            sidebar.classList.toggle('bg-background');
            sidebar.classList.toggle('border-r');
        });
    </script>
</body>
</html>
