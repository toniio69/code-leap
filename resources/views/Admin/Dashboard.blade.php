@extends('layouts.app')

@section('content')
    <div class="admin-dashboard-shell max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="admin-dashboard-header">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="admin-dashboard-badge">Operations overview</p>
                    <h1 class="admin-dashboard-title">Admin Dashboard</h1>
                    <p class="admin-dashboard-subtitle">Monitor student activity, course growth, and platform management in one place.</p>
                </div>
                <div class="admin-dashboard-actions">
                    <a href="{{ route('admin.users') }}" class="admin-dashboard-btn primary">Manage Users</a>
                    <a href="{{ route('courses.create') }}" class="admin-dashboard-btn secondary">Create Course</a>
                </div>
            </div>
        </div>

        <div class="admin-dashboard-grid mb-6">
            <div class="admin-dashboard-card">
                <p>Users</p>
                <p class="admin-dashboard-metric">{{ $usersCount ?? '—' }}</p>
            </div>
            <div class="admin-dashboard-card">
                <p>Courses</p>
                <p class="admin-dashboard-metric">{{ $coursesCount ?? '—' }}</p>
            </div>
            <div class="admin-dashboard-card">
                <p>Enrollments</p>
                <p class="admin-dashboard-metric">{{ $enrollmentsCount ?? '—' }}</p>
            </div>
            <div class="admin-dashboard-card">
                <p>Materials</p>
                <p class="admin-dashboard-metric">{{ $materialsCount ?? '—' }}</p>
            </div>
        </div>

        <div class="admin-dashboard-grid">
            <div class="admin-dashboard-card wide">
                <div class="flex items-center justify-between">
                    <h2>Recent Account Creations</h2>
                    <span class="admin-dashboard-badge">Latest 5</span>
                </div>
                <div class="admin-dashboard-list">
                    @forelse ($recentAccounts as $account)
                        <div class="admin-dashboard-item">
                            <div>
                                <strong>{{ $account->name }}</strong>
                                <span>{{ $account->email }} · {{ ucfirst($account->role) }}</span>
                            </div>
                            <span class="text-sm text-slate-400">{{ $account->created_at?->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="admin-dashboard-item">
                            <span>No accounts have been created yet.</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="admin-dashboard-card">
                <h2>Quick Actions</h2>
                <div class="mt-4 flex flex-col gap-3">
                    <a href="{{ route('courses.create') }}" class="admin-dashboard-btn secondary justify-start">Create Course</a>
                    <a href="{{ route('admin.users') }}" class="admin-dashboard-btn primary justify-start">Manage Users</a>
                    <a href="{{ route('admin.analytics') }}" class="admin-dashboard-btn secondary justify-start">View Analytics</a>
                    <a href="{{ route('admin.student-performance') }}" class="admin-dashboard-btn secondary justify-start">Student Performance</a>
                    <a href="{{ route('admin.payments') }}" class="admin-dashboard-btn secondary justify-start">Payment Transactions</a>
                </div>
            </div>
        </div>
    </div>
@endsection
