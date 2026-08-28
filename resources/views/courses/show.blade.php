@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="space-y-8">
    {{-- Breadcrumbs & Back Nav --}}
    <div class="flex items-center justify-between border-b border-border pb-4">
        <a
            href="{{ route('courses.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Courses
        </a>

        @if((auth()->user()->hasRole('instructor') && auth()->id() === $course->user_id) || auth()->user()->hasRole('admin'))
            <div class="flex items-center gap-2">
                <a
                    href="{{ route('courses.edit', $course) }}"
                    class="inline-flex items-center justify-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium text-foreground transition-colors hover:bg-accent"
                >
                    Edit Course
                </a>
                <form
                    method="POST"
                    action="{{ route('courses.destroy', $course) }}"
                    onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-destructive/10 px-3 py-1.5 text-xs font-semibold text-destructive transition-colors hover:bg-destructive/20"
                    >
                        Delete
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="rounded-lg border border-emerald-500/20 bg-emerald-500/10 p-4 text-xs text-emerald-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-lg border border-destructive/20 bg-destructive/10 p-4 text-xs text-destructive">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Course Overview Card --}}
    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-xs">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 sm:p-8">
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="inline-flex rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary">
                        {{ $course->category ?? 'Software Development' }}
                    </span>
                    @if(($course->price ?? 0) > 0)
                        <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-bold text-primary">
                            ₦{{ number_format($course->price, 2) }}
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-xs font-bold text-emerald-600">
                            Free Course
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                    {{ $course->title }}
                </h1>

                <p class="text-sm leading-relaxed text-muted-foreground">
                    {{ $course->description }}
                </p>

                <div class="pt-4 flex flex-wrap items-center gap-6 text-xs text-muted-foreground border-t border-border">
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                            {{ strtoupper(substr($course->instructor->name ?? 'I', 0, 1)) }}
                        </div>
                        <div>
                            <span class="block text-foreground font-semibold">{{ $course->instructor->name ?? 'Instructor' }}</span>
                            <span class="text-[10px]">Lead Author</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.824-1M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.824-1M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>{{ $course->students->count() }} Enrolled</span>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
                        <span>{{ $course->materials->count() }} Files</span>
                    </div>
                </div>
            </div>

            {{-- Media / CTA Sidebar --}}
            <div class="flex flex-col justify-between space-y-4 rounded-lg border border-border bg-muted/20 p-5">
                <div class="aspect-video w-full overflow-hidden rounded-lg bg-muted border border-border">
                    @if($course->cover_image)
                        <img
                            src="{{ asset('storage/' . $course->cover_image) }}"
                            alt="{{ $course->title }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-muted-foreground">
                            {{ $course->title }}
                        </div>
                    @endif
                </div>

                @php
                    $isEnrolled = auth()->user()->hasRole('student') && $course->students()->where('user_id', auth()->id())->exists();
                @endphp

                <div id="course-cta" class="w-full">
                    @if(auth()->user()->hasRole('student'))
                        @if($isEnrolled)
                            <div class="rounded-lg bg-emerald-500/10 p-3 text-center text-xs font-semibold text-emerald-600 border border-emerald-500/20">
                                ✓ You are enrolled in this course
                            </div>
                        @elseif(($course->price ?? 0) > 0)
                            <a
                                href="{{ route('paystack.pay', $course) }}"
                                class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2.5 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90"
                            >
                                Enroll Premium (₦{{ number_format($course->price, 0) }})
                            </a>
                        @else
                            <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2.5 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90"
                                >
                                    Enroll in Course (Free)
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Interactive Video Player Container (for YouTube provider courses) --}}
    <div id="video-player" class="w-full"></div>

    {{-- Course Lessons & Modules --}}
    <div class="rounded-xl border border-border bg-card shadow-xs">
        <div class="border-b border-border px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-foreground">Course Lessons</h2>
                <p class="text-xs text-muted-foreground">Step-by-step curriculum with code walk-throughs.</p>
            </div>
            @if((auth()->user()->hasRole('instructor') && auth()->id() === $course->user_id) || auth()->user()->hasRole('admin'))
                <a href="{{ route('lessons.create') }}" class="inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent">
                    + Add Lesson
                </a>
            @endif
        </div>

        @if($course->lessons && $course->lessons->count())
            <div class="divide-y divide-border">
                @foreach($course->lessons as $index => $lesson)
                    <div class="flex items-center justify-between p-4 px-6 hover:bg-muted/30 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h3 class="text-xs font-bold text-foreground">{{ $lesson->title }}</h3>
                                <p class="text-[11px] text-muted-foreground line-clamp-1">{{ Str::limit($lesson->content, 80) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($lesson->video_id)
                                <button
                                    onclick="window.renderCourse({ provider: 'youtube', lessons: [{ video_id: '{{ $lesson->video_id }}' }] })"
                                    class="inline-flex items-center gap-1 rounded-md bg-secondary px-3 py-1.5 text-xs font-medium text-secondary-foreground hover:bg-secondary/80"
                                >
                                    <svg class="h-3 w-3 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Video
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-xs text-muted-foreground">
                No lessons added to this course yet.
            </div>
        @endif
    </div>

    {{-- Course Materials & Downloads --}}
    <div class="rounded-xl border border-border bg-card shadow-xs">
        <div class="border-b border-border px-6 py-4">
            <h2 class="text-base font-bold text-foreground">Course Materials & Downloads</h2>
            <p class="text-xs text-muted-foreground">Download source code, presentation slides, and reference cheat sheets.</p>
        </div>

        @if($course->materials->count())
            <div class="divide-y divide-border">
                @foreach($course->materials as $material)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-foreground">{{ $material->title }}</h3>
                                <p class="text-[11px] text-muted-foreground">Resource file</p>
                            </div>
                        </div>

                        <div>
                            @if($isEnrolled || auth()->user()->hasRole('instructor') || auth()->user()->hasRole('admin'))
                                <a
                                    href="{{ asset('storage/' . $material->file_path) }}"
                                    target="_blank"
                                    class="inline-flex items-center justify-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-semibold text-foreground transition-colors hover:bg-accent"
                                >
                                    Download Resource
                                </a>
                            @else
                                <span class="text-xs text-muted-foreground italic">Enrollment required to access</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-xs text-muted-foreground">
                No extra materials attached to this course.
            </div>
        @endif
    </div>
</div>
@endsection
