@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">

```
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                    Free Learning Resources
                </span>

                <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">
                    Online Coding Courses
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-600">
                    Explore programming courses and coding challenges
                    from freeCodeCamp directly through Code Leap.
                </p>

            </div>

            <a
                href="https://www.freecodecamp.org/learn/"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
            >
                Open freeCodeCamp
            </a>

        </div>

    </div>

    {{-- Search --}}
    <div class="mb-8 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

        <form
            action="{{ route('freecodecamp.index') }}"
            method="GET"
            class="flex flex-col gap-3 sm:flex-row"
        >

            <div class="relative flex-1">

                <label
                    for="search"
                    class="sr-only"
                >
                    Search coding courses
                </label>

                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search HTML, CSS, JavaScript, Python..."
                    class="block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

            </div>

            <button
                type="submit"
                class="rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                Search
            </button>

            @if($search)
                <a
                    href="{{ route('freecodecamp.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                >
                    Clear
                </a>
            @endif

        </form>

    </div>

    {{-- API Error --}}
    @isset($error)

        <div class="mb-8 rounded-xl border border-red-200 bg-red-50 p-5">

            <div class="flex">

                <div class="shrink-0">
                    <svg
                        class="h-5 w-5 text-red-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z"
                        />
                    </svg>
                </div>

                <div class="ml-3">

                    <h3 class="text-sm font-semibold text-red-800">
                        Unable to load online courses
                    </h3>

                    <p class="mt-1 text-sm text-red-700">
                        {{ $error }}
                    </p>

                </div>

            </div>

        </div>

    @endisset

    {{-- Course Grid --}}
    @if(count($courses))

        <div class="mb-5 flex items-center justify-between">

            <div>

                <h2 class="text-lg font-bold text-gray-900">
                    Available Learning Paths
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ count($courses) }} learning paths found.
                </p>

            </div>

        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach($courses as $course)

                <article
                    class="group flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-md"
                >

                    {{-- Course Header --}}
                    <div class="relative flex h-40 items-center justify-center bg-gradient-to-br from-indigo-600 to-purple-700">

                        <div class="text-center px-6">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-white/20">

                                <span class="text-2xl font-bold text-white">
                                    &lt;/&gt;
                                </span>

                            </div>

                            <span class="mt-3 block text-xs font-semibold uppercase tracking-wider text-white/80">
                                freeCodeCamp
                            </span>

                        </div>

                    </div>

                    {{-- Course Content --}}
                    <div class="flex flex-1 flex-col p-6">

                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $course['title'] ?? $course['dashedName'] }}
                        </h3>

                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-600">
                            Explore this freeCodeCamp learning path
                            and work through its coding challenges.
                        </p>

                        @if(!empty($course['blocks']))

                            <div class="mt-4 flex items-center text-xs text-gray-500">

                                <svg
                                    class="mr-2 h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"
                                    />
                                </svg>

                                {{ count($course['blocks']) }} learning blocks

                            </div>

                        @endif

                        <div class="mt-auto pt-6">

                            <a
                                href="{{ route('freecodecamp.show', $course['dashedName']) }}"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                            >
                                Explore Course
                                <span class="ml-2">→</span>
                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        {{-- Empty State --}}
        <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

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
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1016.65 16.65z"
                    />
                </svg>

            </div>

            <h3 class="mt-4 text-lg font-semibold text-gray-900">
                No courses found
            </h3>

            <p class="mt-2 text-sm text-gray-500">
                Try searching for another programming topic.
            </p>

        </div>

    @endif

</div>
```

</div>

@endsection
