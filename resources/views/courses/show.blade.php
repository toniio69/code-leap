@extends('layouts.app')

@section('content')

    {{-- Back Navigation --}}
    <div class="mb-6">
        <a
            href="{{ route('courses.index') }}"
            class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800"
        >
            ← Back to Courses
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
            {{ session('info') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Course Card --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

        {{-- Cover Image --}}
        <div class="relative h-64 bg-gray-100 sm:h-80">

            @if($course->cover_image)

                <img
                    src="{{ asset('storage/' . $course->cover_image) }}"
                    alt="{{ $course->title }}"
                    class="h-full w-full object-cover"
                >

            @else

                <div class="flex h-full items-center justify-center">
                    <div class="text-center">
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

                        <p class="mt-3 text-sm font-medium text-gray-500">
                            No cover image available
                        </p>
                    </div>
                </div>

            @endif

            {{-- Course Badge --}}
            <div class="absolute left-5 top-5">
                <span class="inline-flex rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-indigo-700 shadow-sm">
                    Course
                </span>
            </div>

        </div>

        {{-- Course Information --}}
        <div class="p-6 sm:p-8">

            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                <div class="max-w-3xl">

                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        {{ $course->title }}
                    </h1>

                    <p class="mt-4 text-base leading-7 text-gray-600">
                        {{ $course->description }}
                    </p>

                </div>

                {{-- Instructor Actions --}}
                @if(
                    auth()->user()->role === 'instructor' &&
                    auth()->id() === $course->user_id
                )

                    <div class="flex shrink-0 gap-3">

                        <a
                            href="{{ route('courses.edit', $course) }}"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
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
                                class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700"
                            >
                                Delete
                            </button>
                        </form>

                    </div>

                @endif

            </div>

            {{-- Course Meta --}}
            <div class="mt-8 grid gap-4 border-t border-gray-100 pt-6 sm:grid-cols-2">

                {{-- Instructor --}}
                <div class="flex items-center">

                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-100">
                        <span class="font-bold text-indigo-700">
                            {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
                        </span>
                    </div>

                    <div class="ml-3">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            Instructor
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $course->instructor->name }}
                        </p>
                    </div>

                </div>

                {{-- Created Date --}}
                <div class="flex items-center">

                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gray-100">
                        <svg
                            class="h-5 w-5 text-gray-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>

                    <div class="ml-3">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            Created
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $course->created_at->format('M d, Y') }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Enrollment Section --}}
    @if(auth()->user()->role === 'student')

        <div class="mt-8 overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:p-8">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Ready to learn?
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Enroll in this course to access its learning content.
                    </p>
                </div>

                @if($course->students->contains(auth()->id()))

                    <span class="inline-flex items-center justify-center rounded-lg bg-green-100 px-5 py-2.5 text-sm font-semibold text-green-700">
                        ✓ Enrolled
                    </span>

                @else

                    <form
                        method="POST"
                        action="{{ route('courses.enroll', $course) }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Enroll in Course
                        </button>
                    </form>

                @endif

            </div>

        </div>

    @endif

    {{-- Course Statistics --}}
    <div class="mt-8 grid gap-6 sm:grid-cols-2">

        {{-- Students --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

            <div class="flex items-center">

                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-50">
                    <svg
                        class="h-6 w-6 text-indigo-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.824-1M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.824-1M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                </div>

                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">
                        Enrolled Students
                    </p>

                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $course->students->count() }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Materials --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

            <div class="flex items-center">

                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50">
                    <svg
                        class="h-6 w-6 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a2 2 0 00-.586-1.414l-4.414-4.414A2 2 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                        />
                    </svg>
                </div>

                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">
                        Course Materials
                    </p>

                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $course->materials->count() }}
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- Course Materials --}}
    <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

        <div class="border-b border-gray-200 px-6 py-5 sm:px-8">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Course Materials
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Learning resources available for this course.
                    </p>
                </div>

                {{-- Instructor upload link --}}
                @if(
                    auth()->user()->role === 'instructor' &&
                    auth()->id() === $course->user_id
                )

                    <a
                        href="{{ route('materials.create', $course) }}"
                        class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >
                        + Upload Material
                    </a>

                @endif

            </div>

        </div>

        @if($course->materials->count())

            <div class="divide-y divide-gray-100">

                @foreach($course->materials as $material)

                    <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">

                        <div class="flex items-center">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gray-100">
                                <svg
                                    class="h-5 w-5 text-gray-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 011.414.586l4.414 4.414A2 2 0 0119 9.414V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>

                            <div class="ml-4">

                                <h3 class="text-sm font-semibold text-gray-900">
                                    {{ $material->title }}
                                </h3>

                                <p class="mt-1 text-xs text-gray-500">
                                    Course material
                                </p>

                            </div>

                        </div>

                        {{-- Material Access --}}
                        @if(
                            auth()->user()->role === 'instructor' &&
                            auth()->id() === $course->user_id
                        )

                            <a
                                href="{{ asset('storage/' . $material->file_path) }}"
                                target="_blank"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                View Material
                            </a>

                        @elseif(
                            auth()->user()->role === 'student' &&
                            $course->students->contains(auth()->id())
                        )

                            <a
                                href="{{ asset('storage/' . $material->file_path) }}"
                                target="_blank"
                                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                View Material
                            </a>

                        @elseif(auth()->user()->role === 'admin')

                            <a
                                href="{{ asset('storage/' . $material->file_path) }}"
                                target="_blank"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                View Material
                            </a>

                        @else

                            <span class="text-sm text-gray-400">
                                Enrollment required
                            </span>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="px-6 py-12 text-center sm:px-8">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                    <svg
                        class="h-7 w-7 text-gray-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 13h6m-3-3v6m-7 4h10a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-gray-900">
                    No course materials yet
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Course materials will appear here when they are uploaded.
                </p>

            </div>

        @endif

    </div>

@endsection
