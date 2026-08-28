@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="border-b border-border pb-6">
        <a
            href="{{ route('courses.show', $course) }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:text-foreground mb-3"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Course
        </a>

        <h1 class="text-3xl font-bold tracking-tight text-foreground">
            Edit Course
        </h1>

        <p class="mt-1 text-sm text-muted-foreground">
            Update curriculum details, pricing, and course artwork.
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

    {{-- Edit Form --}}
    <div class="rounded-xl border border-border bg-card shadow-xs overflow-hidden">
        <form
            method="POST"
            action="{{ route('courses.update', $course) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="p-6 sm:p-8 space-y-6">
                {{-- Course Title --}}
                <div class="space-y-2">
                    <label for="title" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Course Title
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $course->title) }}"
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
                        Course Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        required
                        class="w-full rounded-md border border-input bg-background p-3.5 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                    >{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
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
                                value="{{ old('price', number_format($course->price ?? 0, 2, '.', '')) }}"
                                placeholder="0.00"
                                class="h-10 w-full rounded-md border border-input bg-background pl-8 pr-3.5 py-2 text-sm shadow-xs focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                            >
                        </div>
                        <p class="text-[11px] text-muted-foreground">Set to 0.00 to make free.</p>
                        @error('price')
                            <p class="text-xs text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                            Course Author
                        </label>
                        <div class="flex h-10 items-center rounded-md border border-border bg-muted/40 px-3.5 text-xs text-foreground font-semibold">
                            {{ $course->instructor->name ?? 'Instructor' }} ({{ $course->instructor->email ?? 'instructor@codeleap.test' }})
                        </div>
                    </div>
                </div>

                {{-- Current Cover Image --}}
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Current Artwork
                    </label>
                    @if($course->cover_image)
                        <div class="aspect-video w-full max-w-sm overflow-hidden rounded-lg border border-border bg-muted">
                            <img
                                src="{{ asset('storage/' . $course->cover_image) }}"
                                alt="{{ $course->title }}"
                                class="h-full w-full object-cover"
                            >
                        </div>
                    @else
                        <div class="flex h-24 max-w-sm items-center justify-center rounded-lg border border-dashed border-border bg-muted/30 text-xs text-muted-foreground">
                            No artwork uploaded.
                        </div>
                    @endif
                </div>

                {{-- Replace Cover Image --}}
                <div class="space-y-2">
                    <label for="cover_image" class="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Replace Artwork (Optional)
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
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-border bg-muted/20 p-4 px-6 sm:px-8">
                <a
                    href="{{ route('courses.show', $course) }}"
                    class="inline-flex items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-xs font-medium text-foreground transition-colors hover:bg-accent"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-md bg-primary px-5 py-2 text-xs font-semibold text-primary-foreground shadow-xs transition-colors hover:bg-primary/90"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

