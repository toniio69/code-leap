@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50 py-10">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

```
    {{-- Header --}}
    <div class="mb-8">
        <a
            href="{{ route('courses.show', $course) }}"
            class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800"
        >
            ← Back to Course
        </a>

        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
            Edit Course
        </h1>

        <p class="mt-2 text-sm text-gray-600">
            Update your course information and cover image.
        </p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
            <h3 class="text-sm font-semibold text-red-800">
                Please correct the following errors:
            </h3>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

        <form
            method="POST"
            action="{{ route('courses.update', $course) }}"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            {{-- Course Information --}}
            <div class="border-b border-gray-200 px-6 py-6 sm:px-8">

                <h2 class="text-lg font-semibold text-gray-900">
                    Course Information
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Update the information students see when browsing your course.
                </p>

                <div class="mt-6 space-y-6">

                    {{-- Course Title --}}
                    <div>
                        <label
                            for="title"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Course Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $course->title) }}"
                            required
                            maxlength="255"
                            class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                        @error('title')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="7"
                            required
                            class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 text-sm leading-6 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description', $course->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label
                            for="price"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Course Price (NGN ₦)
                        </label>

                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">₦</span>
                            </div>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                id="price"
                                name="price"
                                value="{{ old('price', number_format($course->price ?? 0, 2, '.', '')) }}"
                                placeholder="0.00 (Enter 0 for free course)"
                                class="block w-full rounded-lg border-gray-300 pl-8 pr-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Set to 0.00 to make this course free for students.</p>

                        @error('price')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Instructor --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Instructor
                        </label>

                        <div class="mt-2 flex items-center rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">
                                <span class="font-semibold text-indigo-700">
                                    {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
                                </span>
                            </div>

                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $course->instructor->name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $course->instructor->email }}
                                </p>
                            </div>

                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            The course instructor cannot be changed here.
                        </p>
                    </div>

                    {{-- Current Cover Image --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Current Cover Image
                        </label>

                        @if($course->cover_image)

                            <div class="mt-3 overflow-hidden rounded-lg border border-gray-200 bg-gray-100">
                                <img
                                    src="{{ asset('storage/' . $course->cover_image) }}"
                                    alt="{{ $course->title }}"
                                    class="h-64 w-full object-cover"
                                >
                            </div>

                        @else

                            <div class="mt-3 flex h-48 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50">
                                <p class="text-sm text-gray-500">
                                    No cover image uploaded.
                                </p>
                            </div>

                        @endif
                    </div>

                    {{-- Replace Cover Image --}}
                    <div>
                        <label
                            for="cover_image"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Replace Cover Image
                        </label>

                        <div class="mt-2 rounded-lg border-2 border-dashed border-gray-300 px-6 py-8 text-center transition hover:border-indigo-400">

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50">
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
                                        d="M4 16l4.586-4.586a2 2 0 016.828 0L20 16m-2-2l1.586-1.586a2 2 0 012.828 0L22 14m-6-2h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>

                            <label
                                for="cover_image"
                                class="mt-4 block cursor-pointer text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                            >
                                Choose a new image
                            </label>

                            <input
                                id="cover_image"
                                name="cover_image"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                class="sr-only"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                PNG, JPG or WEBP. Maximum size 2MB.
                            </p>

                        </div>

                        @error('cover_image')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse gap-3 bg-gray-50 px-6 py-5 sm:flex-row sm:justify-between sm:px-8">

                {{-- Delete Course --}}
                <div>

                    <form
                        method="POST"
                        action="{{ route('courses.destroy', $course) }}"
                        onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex justify-center rounded-lg border border-red-300 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-50"
                        >
                            Delete Course
                        </button>
                    </form>

                </div>

                {{-- Update / Cancel --}}
                <div class="flex flex-col gap-3 sm:flex-row">

                    <a
                        href="{{ route('courses.show', $course) }}"
                        class="inline-flex justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save Changes
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
```

</div>
@endsection
