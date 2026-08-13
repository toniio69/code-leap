@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="mt-2 text-sm text-gray-600">Welcome back. Here's a quick overview of your learning space.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Browse Courses
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Enrolled Courses</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $enrolledCourses->count() }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">In Progress</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $inProgressCourses->count() }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Completed</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $completedCourses->count() }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Continue learning</h2>
            @if($inProgressCourses->count())
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($inProgressCourses as $course)
                        <a href="{{ route('courses.show', $course) }}" class="block rounded-xl border border-gray-200 p-4 hover:shadow-md transition">
                            <h3 class="font-semibold text-gray-900">{{ $course->title }}</h3>
                            <p class="mt-1 text-sm text-gray-500">Resume course</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="mt-2 text-sm text-gray-600">You are not enrolled in any courses yet. <a href="{{ route('courses.index') }}" class="text-indigo-600 font-semibold">Browse courses</a> to get started.</p>
            @endif
        </div>
    </div>
@endsection
