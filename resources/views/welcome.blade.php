<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased selection:bg-primary selection:text-primary-foreground">
        <!-- Navigation Bar -->
        <header class="sticky top-0 z-50 w-full border-b border-border bg-background/90 backdrop-blur supports-[backdrop-filter]:bg-background/60">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <x-app-logo class="h-9 w-auto" />
                    <span class="text-lg font-bold tracking-tight text-foreground">{{ config('app.name', 'Code Leap') }}</span>
                </a>

                <nav class="flex items-center gap-3">
                    <a href="{{ route('courses.index') }}" class="hidden sm:inline-flex text-sm font-medium text-muted-foreground transition-colors hover:text-foreground">
                        Explore Courses
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex h-9 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex h-9 items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Get Started
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex flex-col items-center justify-center">
            <section class="w-full py-16 sm:py-24 lg:py-32 px-4 sm:px-6 lg:px-8 border-b border-border bg-linear-to-b from-muted/40 via-background to-background">
                <div class="mx-auto max-w-4xl text-center">
                    <div class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-3.5 py-1 text-xs font-semibold text-foreground shadow-xs mb-8">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Next-Gen E-Learning Platform
                    </div>

                    <h1 class="text-4xl font-extrabold tracking-tight text-foreground sm:text-6xl sm:leading-none">
                        Master Software Engineering with <span class="text-primary">{{ config('app.name', 'Code Leap') }}</span>
                    </h1>

                    <p class="mt-6 text-lg sm:text-xl text-muted-foreground max-w-2xl mx-auto leading-relaxed">
                        An interactive learning ecosystem for Students, Instructors, and Developers. Learn programming languages, take structured coding lessons, and earn verified completion certificates.
                    </p>

                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring">
                                Open Workspace
                            </a>
                            <a href="{{ route('courses.index') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-md border border-input bg-background px-8 text-sm font-medium text-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                                Browse Catalog
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-md bg-primary px-8 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring">
                                Create Free Account
                            </a>
                            <a href="{{ route('courses.index') }}" class="inline-flex h-11 w-full sm:w-auto items-center justify-center rounded-md border border-input bg-background px-8 text-sm font-medium text-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                                Explore Courses
                            </a>
                        @endauth
                    </div>
                </div>
            </section>

            <!-- Feature Cards Section -->
            <section class="w-full py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-foreground">Everything You Need to Succeed</h2>
                    <p class="mt-2 text-sm text-muted-foreground">Built with modern tech stacks, hands-on coding challenges, and comprehensive analytics.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-foreground">Interactive Coding Courses</h3>
                        <p class="mt-2 text-sm text-muted-foreground leading-relaxed">Structured programming modules covering Web Development, Python, PHP, JavaScript, and Cloud Architecture.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-foreground">Verified Certificates</h3>
                        <p class="mt-2 text-sm text-muted-foreground leading-relaxed">Earn certificates upon completing courses that validate your technical skills to potential employers.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary mb-4">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-foreground">Global edX Integration</h3>
                        <p class="mt-2 text-sm text-muted-foreground leading-relaxed">Search, discover, and connect with global courses from leading partner institutions directly on Code Leap.</p>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="border-t border-border bg-card py-8 px-4 sm:px-6 lg:px-8 text-xs text-muted-foreground">
            <div class="mx-auto flex max-w-7xl flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <x-app-logo-icon class="h-6 w-auto text-primary" />
                    <span class="font-bold text-foreground">{{ config('app.name', 'Code Leap') }}</span>
                    <span>© {{ date('Y') }}. All rights reserved.</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('courses.index') }}" class="hover:text-foreground">Courses</a>
                    <a href="{{ route('login') }}" class="hover:text-foreground">Sign In</a>
                    <a href="{{ route('register') }}" class="hover:text-foreground">Register</a>
                </div>
            </div>
        </footer>
    </body>
</html>

