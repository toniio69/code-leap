@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    <div class="p-6 space-y-6">
        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#91979f]">Users</p>
                        <p class="text-3xl font-semibold text-[#384551] mt-2">{{ $usersCount ?? '—' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#91979f]">Courses</p>
                        <p class="text-3xl font-semibold text-[#384551] mt-2">{{ $coursesCount ?? '—' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#91979f]">Enrollments</p>
                        <p class="text-3xl font-semibold text-[#384551] mt-2">{{ $enrollmentsCount ?? '—' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#91979f]">Materials</p>
                        <p class="text-3xl font-semibold text-[#384551] mt-2">{{ $materialsCount ?? '—' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Recent Accounts -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-[#e4e6e8] sneat-card">
                <div class="p-6 border-b border-[#e4e6e8]">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-[#384551]">Recent Account Creations</h2>
                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">Latest 5</span>
                    </div>
                </div>
                <div class="divide-y divide-[#e4e6e8]">
                    @forelse ($recentAccounts as $account)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-medium text-[#646e78]">
                                    {{ substr($account->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-[#384551]">{{ $account->name }}</p>
                                    <p class="text-sm text-[#91979f]">{{ $account->email }} · <span class="capitalize">{{ $account->role }}</span></p>
                                </div>
                            </div>
                            <span class="text-sm text-[#91979f]">{{ $account->created_at?->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-[#91979f]">No accounts have been created yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl border border-[#e4e6e8] sneat-card">
                <div class="p-6 border-b border-[#e4e6e8]">
                    <h2 class="text-lg font-semibold text-[#384551]">Quick Actions</h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('courses.create') }}" class="flex items-center gap-3 rounded-lg border border-[#e4e6e8] px-4 py-3 text-sm font-medium text-[#384551] hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create Course
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 rounded-lg border border-[#e4e6e8] px-4 py-3 text-sm font-medium text-[#384551] hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Manage Users
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 rounded-lg border border-[#e4e6e8] px-4 py-3 text-sm font-medium text-[#384551] hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        View Analytics
                    </a>
                    <a href="{{ route('admin.student-performance') }}" class="flex items-center gap-3 rounded-lg border border-[#e4e6e8] px-4 py-3 text-sm font-medium text-[#384551] hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        Student Performance
                    </a>
                    <a href="{{ route('admin.payments') }}" class="flex items-center gap-3 rounded-lg border border-[#e4e6e8] px-4 py-3 text-sm font-medium text-[#384551] hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Payment Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

