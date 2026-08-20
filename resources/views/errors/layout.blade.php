<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Error') - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-gray-900 antialiased">
        <div class="grid min-h-screen w-full xl:grid-cols-2">
            <div class="flex flex-col p-8 xl:p-16">
                <div class="mb-8 flex items-center gap-2 xl:justify-start">
                    <div class="bg-indigo-600 flex size-8 items-center justify-center rounded-lg">
                        <svg class="text-white size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-wider text-gray-800">Code Leap</span>
                </div>

                <div class="mt-8 flex flex-1 flex-col items-center justify-center text-center xl:items-start xl:text-start">
                    <div class="mb-3 flex items-center gap-3">
                        <span class="text-sm font-semibold text-indigo-600">@yield('code')</span>
                    </div>
                    <h1 class="mb-2 text-4xl font-bold text-gray-900">@yield('heading')</h1>
                    <p class="text-gray-600 max-w-md">@yield('message')</p>
                    <a href="{{ url('/') }}" class="mt-8 inline-flex h-9 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Go Back Home</span>
                    </a>
                </div>
            </div>
            <div class="relative hidden xl:block">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-purple-100 dark:from-indigo-950 dark:to-purple-900"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <div class="mx-auto mb-4 flex size-24 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900">
                            <svg class="size-12 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-indigo-900 dark:text-indigo-100">Code Leap</p>
                        <p class="text-sm text-indigo-700 dark:text-indigo-300">Advanced E-Learning Platform</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
