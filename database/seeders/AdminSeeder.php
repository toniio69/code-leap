<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate([
            'name' => config('admin.role'),
            'guard_name' => 'web',
        ]);

        $user = User::updateOrCreate(   
            ['email' => config('admin.email')],
            [
                'name' => config('admin.name'),
                'password' => Hash::make(config('admin.password')),
                'role' => config('admin.role'),
                'email_verified_at' => now(),
            ],
        );

        $user->syncRoles([$role->name]);
    }
}
