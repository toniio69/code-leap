@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

    {{-- Back --}}
    <div class="mb-6">

        <a
            href="{{ route('freecodecamp.index') }}"
            class="text-sm font-semibold text-indigo-600 hover:text-indigo-800"
        >
            ← Back to Online Courses
        </a>

    </div>

    {{-- Course Header --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 px-6 py-10 sm:px-10">

            <span class="inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white">
                freeCodeCamp
            </span>

            <h1 class="mt-5 max-w-3xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
                {{ $course['title'] ?? $course['dashedName'] }}
            </h1>

            <p class="mt-4 max-w-2xl text-sm leading-6 text-indigo-100">
                Follow this freeCodeCamp learning path and complete
                practical coding challenges.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">

                <a
                    href="{{ $course['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-gray-100"
                >
                    Start Learning on freeCodeCamp
                    <span class="ml-2">↗</span>
                </a>

            </div>

        </div>

        {{-- Blocks --}}
        <div class="p-6 sm:p-10">

            <div class="mb-6">

                <h2 class="text-xl font-bold text-gray-900">
                    Course Curriculum
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Explore the learning blocks included in this course.
                </p>

            </div>

            @if(!empty($course['blocks']))

                <div class="divide-y divide-gray-100 rounded-xl border border-gray-200">

                    @foreach($course['blocks'] as $index => $block)

                        <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex items-start">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50">

                                    <span class="text-sm font-bold text-indigo-600">
                                        {{ $index + 1 }}
                                    </span>

                                </div>

                                <div class="ml-4">

                                    <h3 class="text-sm font-semibold text-gray-900">
                                        {{ $block }}
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Coding lesson
                                    </p>

                                </div>

                            </div>

                            <a
                                href="{{ $course['url'] }}/{{ $block }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                            >
                                Open Block ↗
                            </a>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="rounded-xl bg-gray-50 p-8 text-center">

                    <p class="text-sm text-gray-500">
                        Curriculum blocks are not available for this course.
                    </p>

                </div>

            @endif

            {{-- Challenges --}}
            @if(!empty($course['challenges']))

                <div class="mt-10">

                    <h2 class="text-xl font-bold text-gray-900">
                        Challenges
                    </h2>

                    <div class="mt-4 space-y-3">

                        @foreach($course['challenges'] as $challenge)

                            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4">

                                <div>

                                    <h3 class="text-sm font-semibold text-gray-900">
                                        {{ $challenge['title'] }}
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Challenge ID:
                                        {{ $challenge['id'] }}
                                    </p>

                                </div>

                                <a
                                    href="{{ $course['url'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                                >
                                    Start →
                                </a>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
