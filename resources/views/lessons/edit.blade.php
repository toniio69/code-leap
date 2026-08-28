@extends('layouts.app')

@section('title', 'Edit Lesson')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="border-b border-border pb-6">
        <a href="{{ route('courses.lessons.index', $course) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground mb-3">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Lessons
        </a>
        <h1 class="text-3xl font-bold tracking-tight text-foreground">Edit Lesson</h1>
        <p class="mt-1 text-sm text-muted-foreground">Updating module for <span class="font-semibold">{{ $course->title }}</span>.</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-lg border border-destructive/20 bg-destructive/10 p-4">
            <h3 class="text-xs font-semibold text-destructive">Please correct the following errors:</h3>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-destructive">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Lesson Form --}}
    <div class="rounded-xl border border-border bg-card shadow-xs overflow-hidden">
        <form method="POST" action="{{ route('courses.lessons.update', [$course, $lesson]) }}">
            @csrf
            @method('PUT')
            <div class="p-6 sm:p-8 space-y-6">
                {{-- Title --}}
                <div class="space-y-2">
                    <label for="title" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Lesson Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $lesson->title) }}"
                        required
                        maxlength="255"
                        class="h-10 w-full rounded-md border border-input bg-background px-3.5 py-2 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    >
                    @error('title')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div class="space-y-2">
                    <label for="content" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Lesson Content / Notes</label>
                    <textarea
                        id="content"
                        name="content"
                        rows="8"
                        class="w-full rounded-md border border-input bg-background p-3.5 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    >{{ old('content', $lesson->content) }}</textarea>
                    @error('content')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Starter Code --}}
                <div class="space-y-2">
                    <label for="starter_code" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Starter Code (Optional)</label>
                    <textarea
                        id="starter_code"
                        name="starter_code"
                        rows="6"
                        class="w-full rounded-md border border-input bg-background p-3.5 text-sm shadow-xs transition-colors font-mono placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    >{{ old('starter_code', $lesson->starter_code) }}</textarea>
                    @error('starter_code')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-border bg-muted/20 p-4 px-6 sm:px-8">
                <a href="{{ route('courses.lessons.index', $course) }}" class="inline-flex items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-xs font-medium text-foreground transition-colors hover:bg-accent">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-primary px-5 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
