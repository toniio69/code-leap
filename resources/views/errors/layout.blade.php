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
        <main class="mx-auto flex min-h-dvh max-w-7xl flex-col items-center justify-center gap-8 p-8 md:gap-12 md:p-16">
            <div class="w-full">
                <img
                    src="{{ asset('favicon.png') }}"
                    alt="placeholder image"
                    class="aspect-video w-full max-w-7xl rounded-xl object-cover dark:brightness-[0.95] dark:invert"
                />
            </div>

            <div class="text-center">
                <h1 class="mb-2 text-3xl font-bold">@yield('heading')</h1>
                <p class="text-muted-foreground">@yield('message')</p>

                <div class="mt-6 flex items-center justify-center gap-4 md:mt-8">
                    <a href="{{ url('/') }}" class="inline-flex h-9 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        Go Back Home
                    </a>
                    <a href="mailto:support@codeleap.test" class="inline-flex h-9 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        <span>Contact Us</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </main>
    </body>
</html>
