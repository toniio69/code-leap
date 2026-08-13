@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Instructor Dashboard</h1>
                <p class="mt-2 text-sm text-gray-600">Manage your courses and track student progress.</p>
            </div>
            <a href="{{ route('courses.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Create Course
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">My Courses</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $courses->count() }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Students</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalStudents }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Materials</p>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $totalMaterials }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('courses.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Create Course</a>
                <a href="{{ route('instructor.certificates.index') }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">Manage Certificates</a>
            </div>
        </div>
    </div>
@endsection
