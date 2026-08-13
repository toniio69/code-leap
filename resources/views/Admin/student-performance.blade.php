@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Student Performance</h1>
            <p class="mt-2 text-sm text-gray-600">Track student progress and completion rates.</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm mb-8">
            <p class="text-sm font-medium text-gray-500">Overall Completion Rate</p>
            <p class="mt-2 text-4xl font-bold text-gray-900">{{ number_format($completionRate, 1) }}%</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($students as $student)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student->enrolled_courses_count }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student->completed_enrollments_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">No students yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection
