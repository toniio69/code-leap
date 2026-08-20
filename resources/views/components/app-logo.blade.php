@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Code Leap" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <img src="{{ asset('favicon.png') }}" alt="Code Leap" class="size-5 object-contain">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Code Leap" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <img src="{{ asset('favicon.png') }}" alt="Code Leap" class="size-5 object-contain">
        </x-slot>
    </flux:brand>
@endif
