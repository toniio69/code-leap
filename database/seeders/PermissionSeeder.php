<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $instructor = Role::create(['name' => 'instructor', 'guard_name' => 'web']);
        $student = Role::create(['name' => 'student', 'guard_name' => 'web']);

        $permissions = [
            // Admin
            'view analytics',
            'view student performance',
            'view payment transactions',
            'approve certificates',
            'manage users',

            // Instructor
            'view own enrollments',
            'issue certificates',

            // Student
            'browse courses',
            'enroll in free courses',
            'enroll in premium courses',
            'resume courses',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin->syncPermissions([
            'view analytics',
            'view student performance',
            'view payment transactions',
            'approve certificates',
            'manage users',
        ]);

        $instructor->syncPermissions([
            'view own enrollments',
            'issue certificates',
        ]);

        $student->syncPermissions([
            'browse courses',
            'enroll in free courses',
            'enroll in premium courses',
            'resume courses',
        ]);

        User::where('role', 'admin')->each(fn ($user) => $user->assignRole('admin'));
        User::where('role', 'instructor')->each(fn ($user) => $user->assignRole('instructor'));
        User::where('role', 'student')->each(fn ($user) => $user->assignRole('student'));
    }
}
