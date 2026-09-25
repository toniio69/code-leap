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
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@codeleap.test')],
            [
                'name' => env('ADMIN_NAME', 'CodeLeap Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', '1234')),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $user->syncRoles([$role->name]);
    }
}
