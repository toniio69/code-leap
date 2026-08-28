@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    @php
        $stats = [
            'totalStudents' => $usersCount ?? 0,
            'activeCourses' => $coursesCount ?? 0,
            'revenue' => '0.00',
        ];

        $recentUsers = $recentAccounts->map(function ($account) {
            return [
                'id' => $account->id,
                'name' => $account->name,
                'role' => $account->role,
                'course_title' => '—',
            ];
        })->toArray();
    @endphp

    <div id="admin-dashboard-root" data-stats="{{ json_encode($stats) }}" data-recent-users="{{ json_encode($recentUsers) }}"></div>

    @vite('resources/js/admin-dashboard.jsx')
@endsection