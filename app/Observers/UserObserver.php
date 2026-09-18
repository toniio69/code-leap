<?php

namespace App\Observers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserObserver
{
    public function created(User $user): void
    {
        $this->assignSpatieRole($user);
    }

    public function updated(User $user): void
    {
        if ($user->isDirty('role')) {
            $this->assignSpatieRole($user);
        }
    }

    private function assignSpatieRole(User $user): void
    {
        $roleName = $user->role;
        
        $validRoles = ['admin', 'instructor', 'student'];
        if (! in_array($roleName, $validRoles, true)) {
            $roleName = 'student';
        }

        $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();

        if ($role) {
            $user->syncRoles([$role->name]);
        }
    }
}