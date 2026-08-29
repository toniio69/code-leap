@extends('layouts.app')

@section('title', 'Course Lessons')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-6">
        <div>
            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground mb-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Course
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-foreground">Lessons</h1>
            <p class="mt-1 text-sm text-muted-foreground">Manage syllabus for <span class="font-semibold text-foreground">{{ $course->title }}</span></p>
        </div>
        <a href="{{ route('lessons.create', $course) }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
            + Add Lesson
        </a>
    </div>

    {{-- Lessons List --}}
    <div class="rounded-xl border border-border bg-card shadow-xs divide-y divide-border">
        @forelse($lessons as $lesson)
            <div class="flex items-center justify-between p-4 px-6 hover:bg-muted/30 transition-colors">
                <div class="flex items-center gap-4">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                        {{ $loop->iteration }}
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-foreground">{{ $lesson->title }}</h3>
                        <p class="text-xs text-muted-foreground mt-0.5">{{ Str::limit($lesson->content ?? 'No description', 100) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('lessons.edit', [$course, $lesson]) }}" class="inline-flex items-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('lessons.destroy', [$course, $lesson]) }}" onsubmit="return confirm('Delete this lesson?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-md bg-destructive/10 px-3 py-1.5 text-xs font-semibold text-destructive hover:bg-destructive/20">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-xs text-muted-foreground">
                No lessons yet. Create your first lesson to get started.
            </div>
        @endforelse
    </div>
</div>
@endsection
