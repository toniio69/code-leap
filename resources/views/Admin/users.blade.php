@extends('layouts.admin')

@section('page-title', 'Users')

@section('content')
    <div class="p-6 space-y-6">
        <div class="bg-white rounded-xl border border-[#e4e6e8] sneat-card">
            <div class="p-6 border-b border-[#e4e6e8]">
                <h2 class="text-lg font-semibold text-[#384551]">All Users</h2>
                <p class="text-sm text-[#91979f] mt-1">Manage user roles and permissions</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e4e6e8]">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-xs font-medium text-indigo-600">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-medium text-[#384551]">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#646e78]">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'instructor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#91979f]">{{ $user->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="text-sm border border-[#e4e6e8] rounded-lg px-2 py-1 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="instructor" {{ $user->role === 'instructor' ? 'selected' : '' }}>Instructor</option>
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-[#91979f]">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
