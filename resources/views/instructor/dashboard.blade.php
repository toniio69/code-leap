@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-foreground">Instructor Dashboard</h1>
                <p class="mt-1 text-sm text-muted-foreground">Manage your curriculum, upload materials, and issue student certificates.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('instructor.certificates.index') }}" class="inline-flex items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-xs font-semibold text-foreground transition-colors hover:bg-accent hover:text-accent-foreground">
                    Certificates
                </a>
                <a href="{{ route('courses.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
                    + Create Course
                </a>
            </div>
        </div>

        <!-- Metrics Stats -->
        <div class="grid gap-6 sm:grid-cols-3">
            <div class="rounded-xl border border-border bg-card p-6 shadow-xs text-card-foreground">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">My Authored Courses</p>
                    <div class="rounded-lg bg-primary/10 p-2 text-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-foreground">{{ $courses->count() }}</p>
                <p class="mt-1 text-xs text-muted-foreground">Active published modules</p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-xs text-card-foreground">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Total Students</p>
                    <div class="rounded-lg bg-blue-500/10 p-2 text-blue-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-foreground">{{ $totalStudents }}</p>
                <p class="mt-1 text-xs text-muted-foreground">Enrolled learners across courses</p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-xs text-card-foreground">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Learning Materials</p>
                    <div class="rounded-lg bg-emerald-500/10 p-2 text-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-foreground">{{ $totalMaterials }}</p>
                <p class="mt-1 text-xs text-muted-foreground">Uploaded code & notes</p>
            </div>
        </div>

        <!-- Instructor Courses List -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-bold text-foreground">Your Courses</h2>
                    <p class="text-xs text-muted-foreground">Manage and edit your course curricula.</p>
                </div>
                <a href="{{ route('courses.create') }}" class="text-xs font-semibold text-primary hover:underline">
                    Add new course &rarr;
                </a>
            </div>

            @if($courses->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($courses as $course)
                        <div class="flex flex-col justify-between rounded-xl border border-border bg-card p-5 shadow-xs transition-all hover:shadow-md">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-[11px] font-semibold text-primary">
                                        {{ $course->category ?? 'Course' }}
                                    </span>
                                    <span class="text-xs font-mono text-muted-foreground">
                                        {{ $course->enrollments->count() }} enrolled
                                    </span>
                                </div>
                                <h3 class="font-bold text-foreground line-clamp-1">{{ $course->title }}</h3>
                                <p class="mt-1 text-xs text-muted-foreground line-clamp-2">{{ $course->description }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-border flex items-center justify-between gap-2">
                                <a href="{{ route('courses.show', $course) }}" class="text-xs font-semibold text-primary hover:underline">
                                    View Course
                                </a>
                                <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <p class="text-sm text-muted-foreground">You haven't authored any courses yet.</p>
                    <div class="mt-4">
                        <a href="{{ route('courses.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground hover:bg-primary/90">
                            Create Your First Course
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

