@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Available Courses
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                Browse courses and start learning with Code Leap.
            </p>
        </div>

        {{-- Only instructors can create courses --}}
        @if(auth()->user()->role === 'instructor')
            <a
                href="{{ route('courses.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                + Create Course
            </a>
        @endif
    </div>

    {{-- Freemium Filter --}}
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('courses.index') }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ empty($type) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            All
        </a>
        <a href="{{ route('courses.index', ['type' => 'free']) }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ $type === 'free' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Free
        </a>
        <a href="{{ route('courses.index', ['type' => 'premium']) }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ $type === 'premium' ? 'bg-emerald-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Premium
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
            <ul class="list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Courses --}}
    @if($courses->count())

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach($courses as $course)

                @php
                    $isFreeCodeCamp = isset($course->source) && $course->source === 'freecodecamp';
                @endphp

                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-md">

                    {{-- Cover Image --}}
                    <div class="aspect-video bg-gray-100">

                        @if(!$isFreeCodeCamp && $course->cover_image)
                            <img
                                src="{{ asset('storage/' . $course->cover_image) }}"
                                alt="{{ $course->title }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full items-center justify-center">
                                <span class="text-sm font-medium text-gray-400">
                                    No cover image
                                </span>
                            </div>
                        @endif

                    </div>

                    {{-- Course Content --}}
                    <div class="p-6">

                        <div class="mb-3 flex items-center justify-between">
                            <span class="inline-flex rounded-full {{ $isFreeCodeCamp ? 'bg-green-50 text-green-700' : 'bg-indigo-50 text-indigo-700' }} px-3 py-1 text-xs font-semibold">
                                {{ $isFreeCodeCamp ? 'freeCodeCamp' : 'Course' }}
                            </span>

                            @if($isFreeCodeCamp)
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">
                                    Free
                                </span>
                            @elseif(($course->price ?? 0) > 0)
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                    ₦{{ number_format($course->price, 2) }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">
                                    Free
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $course->title }}
                        </h2>

                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-600">
                            {{ $course->description }}
                        </p>

                        {{-- Instructor --}}
                        <div class="mt-5 flex items-center border-t border-gray-100 pt-4">

                            <div class="flex h-9 w-9 items-center justify-center rounded-full {{ $isFreeCodeCamp ? 'bg-green-100' : 'bg-indigo-100' }}">
                                <span class="text-sm font-bold {{ $isFreeCodeCamp ? 'text-green-700' : 'text-indigo-700' }}">
                                    {{ strtoupper(substr($course->instructor->name ?? 'F', 0, 1)) }}
                                </span>
                            </div>

                            <div class="ml-3">
                                <p class="text-xs text-gray-500">
                                    {{ $isFreeCodeCamp ? 'Provider' : 'Instructor' }}
                                </p>

                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $course->instructor->name ?? 'Unknown' }}
                                </p>
                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="mt-6 flex items-center gap-3">

                            @if($isFreeCodeCamp)
                                <a
                                    href="{{ route('freecodecamp.show', $course->dashedName) }}"
                                    class="flex-1 rounded-lg bg-green-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-green-700"
                                >
                                    Explore on freeCodeCamp
                                </a>
                            @else
                                @php
                                    $isEnrolled = auth()->user()->role === 'student' && $course->students()->where('user_id', auth()->id())->exists();
                                    $isCompleted = $isEnrolled && $course->pivot->completed ?? false;
                                @endphp

                                <a
                                    href="{{ route('courses.show', $course) }}"
                                    class="flex-1 rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-indigo-700"
                                >
                                    View Course
                                </a>

                                @if(auth()->user()->role === 'student')
                                    @if($isCompleted)
                                        <span class="rounded-lg bg-green-100 px-4 py-2.5 text-sm font-bold text-green-800">
                                            Completed
                                        </span>
                                    @elseif($isEnrolled)
                                        <a
                                            href="{{ route('courses.show', $course) }}"
                                            class="rounded-lg bg-yellow-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-yellow-700"
                                        >
                                            Resume
                                        </a>
                                    @elseif(($course->price ?? 0) > 0)
                                        <a
                                            href="{{ route('paystack.pay', $course) }}"
                                            class="rounded-lg bg-emerald-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-emerald-700"
                                        >
                                            Enroll Premium
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('courses.enroll', $course) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-green-700">
                                                Enroll Free
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Instructor owns this course --}}
                                @if(
                                    auth()->user()->role === 'instructor' &&
                                    auth()->id() === $course->user_id
                                )

                                    <a
                                        href="{{ route('courses.edit', $course) }}"
                                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                    >
                                        Edit
                                    </a>

                                @endif

                            @endif

                        </div>

                    </div>
                </div>

            @endforeach

        </div>

    @else

        {{-- Empty State --}}
        <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50">
                <svg
                    class="h-8 w-8 text-indigo-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"
                    />
                </svg>
            </div>

            <h3 class="mt-5 text-lg font-semibold text-gray-900">
                No courses available
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm text-gray-600">
                There are currently no courses available.
                Instructors can create the first course.
            </p>

            @if(auth()->user()->role === 'instructor')
                <a
                    href="{{ route('courses.create') }}"
                    class="mt-6 inline-flex rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700"
                >
                    Create Your First Course
                </a>
            @endif

        </div>

    @endif

@endsection
