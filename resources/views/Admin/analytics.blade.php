@extends('layouts.admin')

@section('page-title', 'Analytics')

@section('content')
    <div class="p-6 space-y-6">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Total Courses</p>
                <p class="text-3xl font-semibold text-[#384551] mt-3">{{ $totalCourses }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Total Enrollments</p>
                <p class="text-3xl font-semibold text-[#384551] mt-3">{{ $totalEnrollments }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Completed</p>
                <p class="text-3xl font-semibold text-[#384551] mt-3">{{ $completedEnrollments }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Revenue</p>
                <p class="text-3xl font-semibold text-[#384551] mt-3">₦{{ number_format($totalPayments, 2) }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="bg-white rounded-xl border border-[#e4e6e8] sneat-card">
                <div class="p-6 border-b border-[#e4e6e8]">
                    <h2 class="text-lg font-semibold text-[#384551]">Top Courses</h2>
                    <p class="text-sm text-[#91979f] mt-1">Most enrolled courses on the platform.</p>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($topCourses as $course)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-[#384551]">{{ $course->title }}</p>
                                <p class="text-sm text-[#91979f]">{{ $course->enrollments_count }} enrollments</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#91979f]">No courses yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-[#e4e6e8] sneat-card">
                <div class="p-6 border-b border-[#e4e6e8]">
                    <h2 class="text-lg font-semibold text-[#384551]">Recent Payments</h2>
                    <p class="text-sm text-[#91979f] mt-1">Latest payment activity across the platform.</p>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($recentPayments as $payment)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-[#384551]">{{ $payment->user->name }}</p>
                                <p class="text-sm text-[#91979f]">{{ $payment->course->title ?? 'Direct' }}</p>
                            </div>
                            <span class="text-sm font-semibold {{ $payment->status === 'success' ? 'text-green-600' : 'text-yellow-600' }}">
                                ₦{{ number_format($payment->amount, 2) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-[#91979f]">No payments yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
