@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between border-b border-border pb-4">
        <a href="{{ route('edx.courses.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to edX Courses
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-xs">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 sm:p-8">
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="inline-flex rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary">
                        {{ $course->organization ?? 'edX' }}
                    </span>
                    <span class="text-xs text-muted-foreground font-mono">{{ $course->code }}</span>
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                    {{ $course->title }}
                </h1>

                @if($course->description)
                    <p class="text-sm leading-relaxed text-muted-foreground">
                        {{ $course->description }}
                    </p>
                @endif

                <div class="pt-4 flex flex-wrap items-center gap-6 text-xs text-muted-foreground border-t border-border">
                    @if($course->start_date)
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Starts: {{ $course->start_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                    @if($course->end_date)
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Ends: {{ $course->end_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col justify-between space-y-4 rounded-lg border border-border bg-muted/20 p-5">
                <div class="aspect-video w-full overflow-hidden rounded-lg bg-muted border border-border">
                    @if($course->image_url)
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-muted-foreground">
                            {{ $course->title }}
                        </div>
                    @endif
                </div>

                @if($course->enrollment_url)
                    <a href="{{ $course->enrollment_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2.5 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
                        Enroll on edX
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>