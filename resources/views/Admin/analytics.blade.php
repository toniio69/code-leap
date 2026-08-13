@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
            <p class="mt-2 text-sm text-gray-600">Platform overview and key metrics.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Courses</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalCourses }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Enrollments</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalEnrollments }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Completed</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $completedEnrollments }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Revenue</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">₦{{ number_format($totalPayments, 2) }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 mb-8">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Courses</h2>
                <div class="space-y-3">
                    @forelse($topCourses as $course)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $course->title }}</p>
                                <p class="text-sm text-gray-500">{{ $course->enrollments_count }} enrollments</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No courses yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Payments</h2>
                <div class="space-y-3">
                    @forelse($recentPayments as $payment)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $payment->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $payment->course->title ?? 'Direct' }}</p>
                            </div>
                            <span class="text-sm font-semibold {{ $payment->status === 'success' ? 'text-green-600' : 'text-yellow-600' }}">
                                ₦{{ number_format($payment->amount, 2) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No payments yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
