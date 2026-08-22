<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Error') - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background text-foreground antialiased">
        <main class="flex min-h-screen flex-col items-center justify-center px-4">
            <div class="mx-auto w-full max-w-md text-center">
                <div class="mb-8 flex justify-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-primary/10">
                        <svg class="h-10 w-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <h1 class="mb-4 text-7xl font-bold tracking-tight text-foreground">@yield('code')</h1>
                <h2 class="mb-4 text-2xl font-semibold tracking-tight text-foreground">@yield('heading')</h2>
                <p class="mb-8 text-muted-foreground">@yield('message')</p>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ url('/') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-8 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        Go Back Home
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-8 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        Dashboard
                    </a>
                </div>
            </div>
        </main>
    </body>
</html>
