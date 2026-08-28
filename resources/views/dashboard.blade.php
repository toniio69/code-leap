@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-foreground">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="mt-1 text-sm text-muted-foreground">Track your ongoing learning progress, courses, and certificates.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
                Explore Courses
            </a>
        </div>

        <!-- Metrics Stats Cards (shadcn) -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-border bg-card p-6 shadow-xs text-card-foreground">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Enrolled Courses</p>
                    <div class="rounded-lg bg-primary/10 p-2 text-primary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-foreground">{{ $enrolledCourses->count() }}</p>
                <p class="mt-1 text-xs text-muted-foreground">Total registered subjects</p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-xs text-card-foreground">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">In Progress</p>
                    <div class="rounded-lg bg-amber-500/10 p-2 text-amber-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-foreground">{{ $inProgressCourses->count() }}</p>
                <p class="mt-1 text-xs text-muted-foreground">Active study modules</p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-xs text-card-foreground">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Completed</p>
                    <div class="rounded-lg bg-emerald-500/10 p-2 text-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-foreground">{{ $completedCourses->count() }}</p>
                <p class="mt-1 text-xs text-muted-foreground">Certifications earned</p>
            </div>
        </div>

        <!-- In Progress Courses -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-bold text-foreground">Continue Learning</h2>
                    <p class="text-xs text-muted-foreground">Resume your most recent lessons where you left off.</p>
                </div>
            </div>

            @if($inProgressCourses->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($inProgressCourses as $course)
                        <div class="group flex flex-col justify-between overflow-hidden rounded-xl border border-border bg-card p-5 shadow-xs transition-all hover:shadow-md hover:border-primary/40">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-[11px] font-semibold text-primary">
                                        {{ $course->category ?? 'Programming' }}
                                    </span>
                                    <span class="text-xs text-muted-foreground">
                                        {{ $course->lessons->count() }} lessons
                                    </span>
                                </div>
                                <h3 class="font-bold text-foreground line-clamp-1 group-hover:text-primary transition-colors">{{ $course->title }}</h3>
                                <p class="mt-2 text-xs text-muted-foreground line-clamp-2 leading-relaxed">{{ $course->description }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-border">
                                <a href="{{ route('courses.show', $course) }}" class="inline-flex w-full items-center justify-center rounded-md bg-primary px-3 py-2 text-xs font-semibold text-primary-foreground transition-colors hover:bg-primary/90">
                                    Resume Lesson
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground mb-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-foreground">No active courses in progress</h3>
                    <p class="mt-1 text-xs text-muted-foreground max-w-sm mx-auto">Enroll in courses from our catalog to start building your software projects.</p>
                    <div class="mt-5">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground hover:bg-primary/90">
                            Browse All Courses
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

