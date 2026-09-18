@extends('layouts.app')

@section('title', 'edX Online Courses')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-border pb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-foreground">
                edX Online Courses
            </h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Mirrored courses from edX partners. Synced locally for fast access.
            </p>
        </div>

        @php
    $canSync = auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'));
@endphp

    @if($canSync)
        <form method="POST" action="{{ route('edx.courses.sync') }}" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90">
                Sync from edX
            </button>
        </form>
    @endif
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg border border-emerald-500/20 bg-emerald-500/10 p-4 text-xs text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-wrap items-center gap-4">
        <form method="GET" action="{{ route('edx.courses.index') }}" class="flex-1 min-w-[200px]">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Search courses..." class="h-10 w-full rounded-md border border-input bg-background px-3.5 py-2 text-xs shadow-xs">
        </form>

        <select name="organization" onchange="this.form.submit()" class="h-10 rounded-md border border-input bg-background px-3 py-2 text-xs">
            <option value="">All Organizations</option>
            @foreach($organizations as $org)
                <option value="{{ $org }}" {{ $organization === $org ? 'selected' : '' }}>{{ $org }}</option>
            @endforeach
        </select>
    </div>

    @if($courses->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($courses as $course)
                <div class="group flex flex-col justify-between overflow-hidden rounded-xl border border-border bg-card shadow-xs transition-all hover:shadow-md hover:border-primary/40">
                    <div class="aspect-video w-full overflow-hidden bg-muted">
                        @if($course->image_url)
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-primary/10 to-primary/5 text-xs font-semibold text-primary">
                                {{ $course->title }}
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="mb-3 flex items-center justify-between gap-2">
                                <span class="inline-flex rounded-full bg-secondary px-2.5 py-0.5 text-[11px] font-semibold text-secondary-foreground">
                                    {{ $course->organization ?? 'edX' }}
                                </span>
                                <span class="text-xs text-muted-foreground font-mono">{{ $course->code }}</span>
                            </div>
                            <h3 class="text-base font-bold text-foreground line-clamp-1 group-hover:text-primary transition-colors">
                                {{ $course->title }}
                            </h3>
                            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-muted-foreground">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-border">
                            <a href="{{ route('edx.courses.show', $course->edx_id) }}" class="flex-1 inline-flex items-center justify-center rounded-md bg-primary px-3 py-2 text-xs font-semibold text-primary-foreground transition-colors hover:bg-primary/90">
                                View Course
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @else
        <div class="rounded-xl border border-dashed border-border bg-card p-12 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground mb-3">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 19.477 5.754 18 7.5 18c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"/></svg>
            </div>
            <h3 class="text-base font-bold text-foreground">No edX courses synced yet</h3>
            <p class="mt-1 text-xs text-muted-foreground max-w-sm mx-auto">Click "Sync from edX" to pull the latest courses from the edX API.</p>
        </div>
    @endif
</div>
@endsection