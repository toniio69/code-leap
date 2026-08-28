@extends('layouts.app')

@section('title', 'Available Courses')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-border pb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-foreground">
                Course Catalog
            </h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Explore hands-on software development courses or search global online programs.
            </p>
        </div>

        @if(auth()->user()->hasRole('instructor') || auth()->user()->hasRole('admin'))
            <a
                href="{{ route('courses.create') }}"
                class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90"
            >
                + Create Course
            </a>
        @endif
    </div>

    {{-- Freemium Filter & Search Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="inline-flex rounded-lg border border-border bg-muted/40 p-1">
            <a href="{{ route('courses.index') }}"
               class="rounded-md px-3 py-1.5 text-xs font-medium transition-colors {{ empty($type) ? 'bg-background text-foreground shadow-xs font-semibold' : 'text-muted-foreground hover:text-foreground' }}">
                All Courses
            </a>
            <a href="{{ route('courses.index', ['type' => 'free']) }}"
               class="rounded-md px-3 py-1.5 text-xs font-medium transition-colors {{ $type === 'free' ? 'bg-background text-emerald-600 shadow-xs font-semibold' : 'text-muted-foreground hover:text-foreground' }}">
                Free
            </a>
            <a href="{{ route('courses.index', ['type' => 'premium']) }}"
               class="rounded-md px-3 py-1.5 text-xs font-medium transition-colors {{ $type === 'premium' ? 'bg-background text-primary shadow-xs font-semibold' : 'text-muted-foreground hover:text-foreground' }}">
                Premium
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg border border-emerald-500/20 bg-emerald-500/10 p-4 text-xs text-emerald-700">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg border border-destructive/20 bg-destructive/10 p-4">
            <ul class="list-disc space-y-1 pl-5 text-xs text-destructive">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- edX Global Online Search Integration --}}
    <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
            <div>
                <h2 class="text-base font-bold text-foreground">Global Online Courses (edX Search)</h2>
                <p class="text-xs text-muted-foreground">Discover online courses from top universities and tech providers.</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-[11px] font-semibold text-primary">
                Online Partners
            </span>
        </div>

        <form id="edx-search-form" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input
                    type="search"
                    id="edx-search-input"
                    placeholder="Search Python, React, Data Science, AI..."
                    class="h-10 w-full rounded-md border border-input bg-background px-3.5 py-2 text-xs shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                >
            </div>
            <button
                type="submit"
                class="inline-flex h-10 items-center justify-center rounded-md bg-secondary px-5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring"
            >
                Search edX
            </button>
        </form>

        <div id="edx-search-error" class="mt-4 hidden rounded-lg border border-destructive/20 bg-destructive/10 p-3 text-xs text-destructive"></div>
        <div id="edx-search-loading" class="mt-6 hidden text-center text-xs text-muted-foreground py-4">
            <span class="inline-flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Searching edX course database...
            </span>
        </div>
        <div id="course-list" class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"></div>
    </div>

    {{-- Native Code Leap Courses Grid --}}
    <div>
        <div class="mb-4">
            <h2 class="text-lg font-bold text-foreground">Code Leap Curriculum</h2>
            <p class="text-xs text-muted-foreground">Original interactive courses with project-based milestones and certificates.</p>
        </div>

        @if($courses->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($courses as $course)
                    <div class="group flex flex-col justify-between overflow-hidden rounded-xl border border-border bg-card shadow-xs transition-all hover:shadow-md hover:border-primary/40">
                        {{-- Cover Image --}}
                        <div class="aspect-video w-full overflow-hidden bg-muted">
                            @if($course->cover_image)
                                <img
                                    src="{{ asset('storage/' . $course->cover_image) }}"
                                    alt="{{ $course->title }}"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-primary/10 to-primary/5 text-xs font-semibold text-primary">
                                    {{ $course->title }}
                                </div>
                            @endif
                        </div>

                        {{-- Course Content --}}
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="mb-3 flex items-center justify-between gap-2">
                                    <span class="inline-flex rounded-full bg-secondary px-2.5 py-0.5 text-[11px] font-semibold text-secondary-foreground">
                                        {{ $course->category ?? 'Coding' }}
                                    </span>

                                    @if(($course->price ?? 0) > 0)
                                        <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-bold text-primary">
                                            ₦{{ number_format($course->price, 2) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-xs font-bold text-emerald-600">
                                            Free
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-bold text-foreground line-clamp-1 group-hover:text-primary transition-colors">
                                    {{ $course->title }}
                                </h3>

                                <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-muted-foreground">
                                    {{ $course->description }}
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-border">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                                        {{ strtoupper(substr($course->instructor->name ?? 'I', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-xs font-semibold text-foreground">{{ $course->instructor->name ?? 'Code Leap Instructor' }}</p>
                                        <p class="text-[10px] text-muted-foreground">{{ $course->lessons->count() }} Lessons</p>
                                    </div>
                                </div>

                                @php
                                    $isEnrolled = auth()->user()->hasRole('student') && $course->students()->where('user_id', auth()->id())->exists();
                                    $isCompleted = false;
                                    if ($isEnrolled) {
                                        $enrollment = $course->students()->where('user_id', auth()->id())->first();
                                        $isCompleted = $enrollment->pivot->completed ?? false;
                                    }
                                @endphp

                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('courses.show', $course) }}"
                                        class="flex-1 inline-flex items-center justify-center rounded-md border border-input bg-background px-3 py-2 text-xs font-semibold text-foreground transition-colors hover:bg-accent"
                                    >
                                        Details
                                    </a>

                                    @if(auth()->user()->hasRole('student'))
                                        @if($isCompleted)
                                            <span class="inline-flex items-center justify-center rounded-md bg-emerald-500/10 px-3 py-2 text-xs font-bold text-emerald-600">
                                                Completed
                                            </span>
                                        @elseif($isEnrolled)
                                            <a
                                                href="{{ route('courses.show', $course) }}"
                                                class="flex-1 inline-flex items-center justify-center rounded-md bg-amber-600 px-3 py-2 text-xs font-semibold text-white transition-colors hover:bg-amber-700"
                                            >
                                                Resume
                                            </a>
                                        @elseif(($course->price ?? 0) > 0)
                                            <a
                                                href="{{ route('paystack.pay', $course) }}"
                                                class="flex-1 inline-flex items-center justify-center rounded-md bg-primary px-3 py-2 text-xs font-semibold text-primary-foreground transition-colors hover:bg-primary/90"
                                            >
                                                Enroll (₦{{ number_format($course->price, 0) }})
                                            </a>
                                        @else
                                            <form method="POST" action="{{ route('courses.enroll', $course) }}" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex items-center justify-center rounded-md bg-primary px-3 py-2 text-xs font-semibold text-primary-foreground transition-colors hover:bg-primary/90">
                                                    Enroll Free
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if((auth()->user()->hasRole('instructor') && auth()->id() === $course->user_id) || auth()->user()->hasRole('admin'))
                                        <a
                                            href="{{ route('courses.edit', $course) }}"
                                            class="inline-flex items-center justify-center rounded-md border border-input bg-background px-3 py-2 text-xs font-medium hover:bg-accent"
                                        >
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-dashed border-border bg-card p-12 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground mb-3">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 19.477 5.754 18 7.5 18c1.747 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"/></svg>
                </div>
                <h3 class="text-base font-bold text-foreground">No native courses available</h3>
                <p class="mt-1 text-xs text-muted-foreground max-w-sm mx-auto">Instructors can create lessons or you can search external edX programs above.</p>
                @if(auth()->user()->hasRole('instructor') || auth()->user()->hasRole('admin'))
                    <div class="mt-4">
                        <a href="{{ route('courses.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground hover:bg-primary/90">
                            Create First Course
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('edx-search-form');
        const input = document.getElementById('edx-search-input');
        const list = document.getElementById('course-list');
        const errorBox = document.getElementById('edx-search-error');
        const loading = document.getElementById('edx-search-loading');

        if (!form) return;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const query = input.value.trim();
            list.innerHTML = '';
            errorBox.classList.add('hidden');
            loading.classList.remove('hidden');

            try {
                const response = await fetch(`/api/courses/edx/search?query=${encodeURIComponent(query)}`);
                loading.classList.add('hidden');

                if (!response.ok) {
                    throw new Error('Search failed');
                }

                const data = await response.json();
                if (!Array.isArray(data) || data.length === 0) {
                    list.innerHTML = '<p class="text-xs text-muted-foreground col-span-full py-4 text-center">No online edX courses found matching your query.</p>';
                    return;
                }

                data.forEach(course => {
                    if (typeof window.renderCourse === 'function') {
                        window.renderCourse(course, 'course-list');
                    }
                });
            } catch (err) {
                loading.classList.add('hidden');
                errorBox.textContent = 'Unable to search edX courses at this time. Please try again.';
                errorBox.classList.remove('hidden');
            }
        });
    })();
</script>
@endpush

