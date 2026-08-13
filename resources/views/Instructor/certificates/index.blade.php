@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Certificates</h1>
            <p class="mt-2 text-sm text-gray-600">Issue and manage course completion certificates.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pending Approval</h2>
                <div class="space-y-3">
                    @forelse($pendingCertificates as $certificate)
                        <div class="flex items-center justify-between p-4 rounded-lg border border-gray-100">
                            <div>
                                <p class="font-medium text-gray-900">{{ $certificate->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $certificate->course->title }}</p>
                            </div>
                            <form method="POST" action="{{ route('instructor.certificates.issue', $certificate) }}">
                                @csrf
                                @method('POST')
                                <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                    Issue
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No pending certificates.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Issued Certificates</h2>
                <div class="space-y-3">
                    @forelse($issuedCertificates as $certificate)
                        <div class="flex items-center justify-between p-4 rounded-lg border border-gray-100">
                            <div>
                                <p class="font-medium text-gray-900">{{ $certificate->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $certificate->course->title }}</p>
                            </div>
                            <span class="text-sm font-semibold text-green-600">Issued</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No issued certificates yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
