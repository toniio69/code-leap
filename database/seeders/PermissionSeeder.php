<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::query()->delete();
        Role::query()->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();

        Cache::forget('spatie.permission.cache');

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $instructor = Role::create(['name' => 'instructor', 'guard_name' => 'web']);
        $student = Role::create(['name' => 'student', 'guard_name' => 'web']);

        $permissions = [
            'view analytics',
            'view student performance',
            'view payment transactions',
            'approve certificates',
            'manage users',
            'view own enrollments',
            'issue certificates',
            'browse courses',
            'enroll in free courses',
            'enroll in premium courses',
            'resume courses',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminPermIds = Permission::whereIn('name', [
            'view analytics',
            'view student performance',
            'view payment transactions',
            'approve certificates',
            'manage users',
            'view own enrollments',
            'issue certificates',
            'browse courses',
            'enroll in free courses',
            'enroll in premium courses',
            'resume courses',
        ])->pluck('id')->toArray();

        $instructorPermIds = Permission::whereIn('name', [
            'view own enrollments',
            'issue certificates',
        ])->pluck('id')->toArray();

        $studentPermIds = Permission::whereIn('name', [
            'browse courses',
            'enroll in free courses',
            'enroll in premium courses',
            'resume courses',
        ])->pluck('id')->toArray();

        foreach ($adminPermIds as $permId) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permId,
            ]);
        }

        foreach ($instructorPermIds as $permId) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $instructor->id,
                'permission_id' => $permId,
            ]);
        }

        foreach ($studentPermIds as $permId) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $student->id,
                'permission_id' => $permId,
            ]);
        }

        User::where('role', 'admin')->each(fn ($user) => $user->assignRole('admin'));
        User::where('role', 'instructor')->each(fn ($user) => $user->assignRole('instructor'));
        User::where('role', 'student')->each(fn ($user) => $user->assignRole('student'));
    }
}
