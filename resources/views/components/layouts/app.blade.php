<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Welcome') - {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <nav class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('Code Leap logo.png') }}" alt="Code Leap" class="h-8 w-auto">
                <span class="text-xl font-bold tracking-wider text-gray-800">{{ config('app.name') }}</span>
            </a>
            <div class="flex items-center gap-3 text-sm text-gray-600">
                @auth
                    <a
                        href="{{ route('freecodecamp.index') }}"
                        class="text-sm font-semibold text-gray-700 hover:text-indigo-600"
                    >
                        Online Coding
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">Admin</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-gray-900">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
