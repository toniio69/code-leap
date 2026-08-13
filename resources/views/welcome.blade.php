<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeLeap - Advanced E-Learning</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black tracking-tight text-indigo-600">Code<span class="text-gray-900">Leap</span></span>
            </div>
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Sign in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-6">
            🚀 Learn Laravel Best Practices
        </span>
        <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl mb-6">
            Advance Your Skills with <span class="text-indigo-6xl text-indigo-600">CodeLeap</span>
        </h1>
        <p class="max-w-2xl mx-auto text-lg text-gray-600 mb-10">
            A real-time authenticated environment built for Students, Instructors, and Admins to manage course delivery safely and smoothly.
        </p>
        <div class="flex justify-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="px-6 py-3 font-semibold text-white bg-indigo-600 rounded-xl shadow-md hover:bg-indigo-700 transition">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="px-6 py-3 font-semibold text-white bg-indigo-600 rounded-xl shadow-md hover:bg-indigo-700 transition">Get Started Free</a>
                <a href="{{ route('login') }}" class="px-6 py-3 font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">Sign in</a>
            @endauth
        </div>
    </main>

</body>
</html>
