@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

    <a
        href="{{ route('freecodecamp.index') }}"
        class="text-sm font-semibold text-indigo-600 hover:text-indigo-800"
    >
        ← Back to Courses
    </a>

    <div class="mt-6 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:p-8">

        <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
            freeCodeCamp Chapter
        </span>

        <h1 class="mt-2 text-2xl font-bold text-gray-900">
            {{ ucwords(str_replace('-', ' ', $chapter)) }}
        </h1>

        <div class="mt-8 space-y-4">

            @forelse($modules as $module)

                <div class="rounded-lg border border-gray-200 p-5">

                    <h2 class="font-semibold text-gray-900">
                        {{ ucwords(str_replace('-', ' ', $module['dashedName'])) }}
                    </h2>

                    @if(!empty($module['blockObjects']))

                        <div class="mt-4 space-y-2">

                            @foreach($module['blockObjects'] as $block)

                                <div class="rounded-lg bg-gray-50 p-4">

                                    <h3 class="text-sm font-semibold text-gray-900">
                                        {{ $block['title'] }}
                                    </h3>

                                    @if(!empty($block['challenges']))

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ count($block['challenges']) }}
                                            challenges
                                        </p>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            @empty

                <div class="py-12 text-center">

                    <p class="text-sm text-gray-500">
                        No modules were found.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection
