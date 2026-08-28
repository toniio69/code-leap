@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="{{ config('app.name', 'Code Leap') }}" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-primary/10 text-primary">
            <img src="{{ asset('Code Leap logo.png') }}" alt="Code Leap" class="size-6 object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="{{ config('app.name', 'Code Leap') }}" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-primary/10 text-primary">
            <img src="{{ asset('Code Leap logo.png') }}" alt="Code Leap" class="size-6 object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
        </x-slot>
    </flux:brand>
@endif

