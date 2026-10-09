@extends('layouts.admin')

@section('page-title', 'Student Performance')

@section('content')
    <div class="p-6 space-y-6">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Overall Completion Rate</p>
                <p class="text-4xl font-semibold text-[#384551] mt-2">{{ number_format($completionRate, 1) }}%</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Total Students</p>
                <p class="text-4xl font-semibold text-[#384551] mt-2">{{ $students->total() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Avg. Enrollments per Student</p>
                <p class="text-4xl font-semibold text-[#384551] mt-2">{{ $students->avg('enrolled_courses_count') ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[#e4e6e8] sneat-card">
            <div class="p-6 border-b border-[#e4e6e8]">
                <h2 class="text-lg font-semibold text-[#384551]">Student Progress</h2>
                <p class="text-sm text-[#91979f] mt-1">Track student progress and completion rates.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Enrolled</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Completed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e4e6e8]">
                        @forelse($students as $student)
                            @php
                                $progress = $student->enrolled_courses_count > 0 ? round(($student->completed_enrollments_count / $student->enrolled_courses_count) * 100) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#384551]">{{ $student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#646e78]">{{ $student->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#646e78]">{{ $student->enrolled_courses_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#646e78]">{{ $student->completed_enrollments_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-[#384551] w-12">{{ $progress }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-[#91979f]">No students yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#e4e6e8]">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection
