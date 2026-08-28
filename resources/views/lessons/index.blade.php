@extends('layouts.app')

@section('title', $course->title . ' - Lessons')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-6">
        <div>
            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground mb-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Course
            </a>
            <h1 class="text-3xl font-bold tracking-tight text-foreground">Course Lessons</h1>
            <p class="mt-1 text-sm text-muted-foreground">{{ $course->title }} — {{ $lessons->count() }} lesson{{ $lessons->count() !== 1 ? 's' : '' }}</p>
        </div>
        @can('update', $course)
        <a href="{{ route('courses.lessons.create', $course) }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
            + Add Lesson
        </a>
        @endcan
    </div>

    {{-- Lessons List --}}
    @if($lessons->count())
        <div class="rounded-xl border border-border bg-card shadow-xs divide-y divide-border">
            @foreach($lessons as $index => $lesson)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 px-6 hover:bg-muted/30 transition-colors">
                    <div class="flex items-start gap-4">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <h3 class="text-sm font-bold text-foreground">{{ $lesson->title }}</h3>
                            <p class="mt-1 text-xs text-muted-foreground line-clamp-2">{{ Str::limit($lesson->content, 120) }}</p>
                            @if($lesson->video_id)
                                <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-red-500/10 px-2 py-0.5 text-[11px] font-semibold text-red-600">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    Video Lesson
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:ml-4">
                        <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" class="inline-flex items-center justify-center rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium hover:bg-accent">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}" onsubmit="return confirm('Delete this lesson?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-destructive/10 px-3 py-1.5 text-xs font-semibold text-destructive transition-colors hover:bg-destructive/20">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="rounded-xl border border-dashed border-border bg-card p-12 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground mb-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 19.477 5.754 18 7.5 18c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"/></svg>
            </div>
            <h3 class="text-base font-bold text-foreground">No lessons yet</h3>
            <p class="mt-1 text-xs text-muted-foreground max-w-sm mx-auto">Start building the curriculum by adding your first lesson.</p>
            @can('update', $course)
            <div class="mt-4">
                <a href="{{ route('courses.lessons.create', $course) }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground hover:bg-primary/90">
                    Create First Lesson
                </a>
            </div>
            @endcan
        </div>
    @endif
</div>
@endsection
