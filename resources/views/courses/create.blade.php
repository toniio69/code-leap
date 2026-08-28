@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="border-b border-border pb-6">
        <a
            href="{{ route('courses.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground mb-3"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Courses
        </a>

        <h1 class="text-3xl font-bold tracking-tight text-foreground">
            Create New Course
        </h1>

        <p class="mt-1 text-sm text-muted-foreground">
            Author a new curriculum and upload course resources for students.
        </p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-lg border border-destructive/20 bg-destructive/10 p-4">
            <h3 class="text-xs font-semibold text-destructive">
                Please correct the following errors:
            </h3>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-destructive">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Course Form --}}
    <div class="rounded-xl border border-border bg-card shadow-xs overflow-hidden">
        <form
            method="POST"
            action="{{ route('courses.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="p-6 sm:p-8 space-y-6">
                {{-- Title --}}
                <div class="space-y-2">
                    <label for="title" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Course Title
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="e.g. Modern Full-Stack Development with React & Laravel"
                        required
                        maxlength="255"
                        class="h-10 w-full rounded-md border border-input bg-background px-3.5 py-2 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    >
                    @error('title')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="space-y-2">
                    <label for="description" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Course Description & Objectives
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Provide details about what students will build, prerequisites, and learning milestones..."
                        required
                        class="w-full rounded-md border border-input bg-background p-3.5 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price & Category --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2">
                        <label for="price" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                            Course Price (₦ NGN)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-xs text-muted-foreground font-semibold">₦</span>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                id="price"
                                name="price"
                                value="{{ old('price', '0.00') }}"
                                placeholder="0.00 (0 for free)"
                                class="h-10 w-full rounded-md border border-input bg-background pl-8 pr-3.5 py-2 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >
                        </div>
                        <p class="text-[11px] text-muted-foreground">Leave 0.00 to offer free enrollment.</p>
                        @error('price')
                            <p class="text-xs text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                            Assigned Instructor
                        </label>
                        <div class="flex h-10 items-center rounded-md border border-border bg-muted/40 px-3.5 text-xs text-foreground font-semibold">
                            {{ auth()->user()->name }} ({{ auth()->user()->email }})
                        </div>
                    </div>
                </div>

                {{-- Cover Image --}}
                <div class="space-y-2">
                    <label for="cover_image" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Cover Image (Optional)
                    </label>
                    <input
                        id="cover_image"
                        name="cover_image"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full text-xs text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"
                    >
                    <p class="text-[11px] text-muted-foreground">PNG, JPG, or WEBP up to 2MB.</p>
                    @error('cover_image')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-border bg-muted/20 p-4 px-6 sm:px-8">
                <a
                    href="{{ route('courses.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-xs font-medium text-foreground transition-colors hover:bg-accent"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-md bg-primary px-5 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90"
                >
                    Create Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

