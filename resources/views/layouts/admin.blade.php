<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .sneat-sidebar { width: 16.25rem; }
            .sneat-navbar { height: 64px; }
            .sneat-card { box-shadow: 0 0.1875rem 0.5rem 0 rgba(34, 48, 62, 0.1); }
            .sneat-menu-item { padding: 0.3125rem 0.9375rem; }
            .sneat-menu-item.active { background-color: rgba(105, 108, 255, 0.08); color: #696cff; border-right: 3px solid #696cff; }
            .sneat-menu-item:hover { background-color: #f2f3f3; color: #384551; }
        </style>
    </head>
    <body class="bg-[#f5f5f9] text-[#646e78] antialiased">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="sneat-sidebar fixed inset-y-0 left-0 z-50 bg-white border-r border-[#e4e6e8] overflow-y-auto transition-transform duration-300" id="sneat-sidebar">
                <div class="flex items-center gap-3 px-6 h-16 border-b border-[#e4e6e8]">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('Code Leap logo.png') }}" alt="Code Leap" class="h-8 w-auto">
                        <span class="text-lg font-bold tracking-wider text-[#384551]">{{ config('app.name') }}</span>
                    </a>
                </div>

                <nav class="p-4 space-y-6">
                    <div>
                        <p class="px-3 mb-2 text-xs font-semibold text-[#91979f] uppercase tracking-wider">Dashboards</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-[#384551]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Admin Dashboard
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="px-3 mb-2 text-xs font-semibold text-[#91979f] uppercase tracking-wider">Management</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.users') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium {{ request()->routeIs('admin.users') ? 'active' : 'text-[#384551]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Users
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.analytics') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium {{ request()->routeIs('admin.analytics') ? 'active' : 'text-[#384551]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Analytics
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.student-performance') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium {{ request()->routeIs('admin.student-performance') ? 'active' : 'text-[#384551]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                    Student Performance
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.payments') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium {{ request()->routeIs('admin.payments') ? 'active' : 'text-[#384551]' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    Payment Transactions
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <p class="px-3 mb-2 text-xs font-semibold text-[#91979f] uppercase tracking-wider">Platform</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('freecodecamp.index') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium text-[#384551]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                    Online Coding
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('courses.index') }}" class="sneat-menu-item flex items-center gap-3 rounded-md text-sm font-medium text-[#384551]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    Courses
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 ml-64">
                <!-- Navbar -->
                <nav class="sneat-navbar sticky top-0 z-40 bg-white border-b border-[#e4e6e8] px-6 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
                            <svg class="w-6 h-6 text-[#646e78]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-lg font-semibold text-[#384551]">@yield('page-title', 'Admin')</h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        <div class="hidden md:flex items-center">
                            <span class="p-2 text-[#91979f]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" placeholder="Search..." class="w-64 border-0 bg-transparent text-sm focus:ring-0 placeholder-[#91979f]">
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5 text-[#646e78]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-medium">
                                    {{ auth()->user()->initials() }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-[#384551]">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-[#91979f] capitalize">{{ auth()->user()->role }}</p>
                                </div>
                                <svg class="w-4 h-4 text-[#91979f] hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-[#e4e6e8] shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[#384551] hover:bg-gray-50">Profile</a>
                                <a href="{{ route('security.edit') }}" class="block px-4 py-2 text-sm text-[#384551] hover:bg-gray-50">Settings</a>
                                <div class="border-t border-[#e4e6e8] my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <main class="min-h-[calc(100vh-64px)]">
                    @yield('content')
                </main>

                <!-- Footer -->
                <footer class="border-t border-[#e4e6e8] bg-white px-6 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                        <p class="text-sm text-[#91979f]">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        <p class="text-sm text-[#91979f]">Built with Sneat-inspired design</p>
                    </div>
                </footer>
            </div>
        </div>

        <script>
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                document.getElementById('sneat-sidebar').classList.toggle('-translate-x-full');
            });
        </script>
    </body>
</html>
