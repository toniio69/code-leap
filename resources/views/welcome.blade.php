<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-background text-foreground antialiased">
        <header class="sticky top-0 z-50 w-full border-b border-border bg-background/80 backdrop-blur">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('Code Leap logo.png') }}" alt="Code Leap" class="h-8 w-auto">
                    <span class="text-lg font-bold tracking-wider">{{ config('app.name') }}</span>
                </div>
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Sign in
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Get Started
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex min-h-[calc(100vh-4rem)] flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary/10 text-primary mb-6">
                    Master Coding Skills
                </span>

                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl mb-6">
                    Advance Your Skills with <span class="text-primary">{{ config('app.name') }}</span>
                </h1>

                <p class="text-lg text-muted-foreground mb-10 max-w-2xl mx-auto">
                    A real-time authenticated environment built for Students, Instructors, and Admins to manage course delivery safely and smoothly.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-8 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Sign in
                        </a>
                    @endauth
                </div>
            </div>
        </main>
    </body>
</html>
