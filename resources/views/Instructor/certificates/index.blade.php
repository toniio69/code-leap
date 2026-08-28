@extends('layouts.app')

@section('title', 'Certificates')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="border-b border-border pb-6">
            <h1 class="text-3xl font-bold tracking-tight text-foreground">Course Certificates</h1>
            <p class="mt-1 text-sm text-muted-foreground">Review completed course student requirements and issue verified credentials.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Pending Certificates -->
            <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-foreground">Pending Approval</h2>
                    <span class="rounded-full bg-amber-500/10 px-2.5 py-0.5 text-xs font-semibold text-amber-600">
                        {{ $pendingCertificates->count() }} Pending
                    </span>
                </div>
                <div class="space-y-3">
                    @forelse($pendingCertificates as $certificate)
                        <div class="flex items-center justify-between p-4 rounded-lg border border-border bg-muted/30">
                            <div>
                                <p class="text-sm font-bold text-foreground">{{ $certificate->user->name }}</p>
                                <p class="text-xs text-muted-foreground">{{ $certificate->course->title }}</p>
                            </div>
                            <form method="POST" action="{{ route('instructor.certificates.issue', $certificate) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-primary px-3 py-1.5 text-xs font-semibold text-primary-foreground transition-colors hover:bg-primary/90 shadow-xs">
                                    Issue Certificate
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-muted-foreground">
                            No certificates awaiting approval.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Issued Certificates -->
            <div class="rounded-xl border border-border bg-card p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-foreground">Issued Certificates</h2>
                    <span class="rounded-full bg-emerald-500/10 px-2.5 py-0.5 text-xs font-semibold text-emerald-600">
                        {{ $issuedCertificates->count() }} Issued
                    </span>
                </div>
                <div class="space-y-3">
                    @forelse($issuedCertificates as $certificate)
                        <div class="flex items-center justify-between p-4 rounded-lg border border-border bg-muted/30">
                            <div>
                                <p class="text-sm font-bold text-foreground">{{ $certificate->user->name }}</p>
                                <p class="text-xs text-muted-foreground">{{ $certificate->course->title }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                Issued
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-muted-foreground">
                            No issued certificates yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

