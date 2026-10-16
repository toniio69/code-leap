<?php

// One-off: allocate model_has_permissions for every user based on their assigned role.
// Keeps model_has_permissions in sync with role_has_permissions.
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$modelType = 'App\\Models\\User';

echo "BEFORE:\n";
echo '  model_has_permissions rows: '.DB::table('model_has_permissions')->count()."\n";
echo '  model_has_roles rows: '.DB::table('model_has_roles')->count()."\n";

// Users missing a Spatie role assignment entirely.
$usersWithoutRole = DB::table('users')
    ->leftJoin('model_has_roles', function ($join) use ($modelType) {
        $join->on('model_has_roles.model_id', '=', 'users.id')
            ->where('model_has_roles.model_type', $modelType);
    })
    ->whereNull('model_has_roles.role_id')
    ->select('users.id', 'users.email', 'users.role')
    ->get();

echo "\nUsers without a Spatie role: ".$usersWithoutRole->count()."\n";
foreach ($usersWithoutRole as $u) {
    echo "  #{$u->id} {$u->email} (role column: {$u->role})\n";
}

// Backfill model_has_roles for users that only have the role column set.
$roleIds = DB::table('roles')->where('guard_name', 'web')->pluck('id', 'name');
foreach ($usersWithoutRole as $u) {
    $roleName = in_array($u->role, ['admin', 'instructor', 'student'], true) ? $u->role : 'student';
    $roleId = $roleIds[$roleName] ?? null;
    if (! $roleId) {
        echo "  SKIP user #{$u->id}: role '{$roleName}' not found\n";

        continue;
    }
    DB::table('model_has_roles')->insert([
        'role_id' => $roleId,
        'model_type' => $modelType,
        'model_id' => $u->id,
    ]);
    echo "  ASSIGNED user #{$u->id} => {$roleName}\n";
}

// Sync model_has_permissions: give each user a direct permission entry for
// every permission their role grants (mirrors role_has_permissions).
$users = DB::table('users')->orderBy('id')->get();
$inserted = 0;
$removed = 0;

foreach ($users as $u) {
    $roleNames = DB::table('model_has_roles')
        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('model_has_roles.model_type', $modelType)
        ->where('model_has_roles.model_id', $u->id)
        ->pluck('roles.name');

    $permIds = DB::table('role_has_permissions')
        ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
        ->whereIn('roles.name', $roleNames)
        ->pluck('role_has_permissions.permission_id')
        ->unique()
        ->values();

    $existing = DB::table('model_has_permissions')
        ->where('model_type', $modelType)
        ->where('model_id', $u->id)
        ->pluck('permission_id');

    // Remove direct permissions the user's role no longer grants.
    foreach ($existing as $pid) {
        if (! $permIds->contains($pid)) {
            DB::table('model_has_permissions')
                ->where('model_type', $modelType)
                ->where('model_id', $u->id)
                ->where('permission_id', $pid)
                ->delete();
            $removed++;
        }
    }

    // Add direct permissions granted by the role but not yet on the model.
    foreach ($permIds as $pid) {
        if (! $existing->contains($pid)) {
            DB::table('model_has_permissions')->insert([
                'permission_id' => $pid,
                'model_type' => $modelType,
                'model_id' => $u->id,
            ]);
            $inserted++;
        }
    }
}

echo "\nAFTER:\n";
echo '  model_has_permissions rows: '.DB::table('model_has_permissions')->count()."\n";
echo '  inserted: '.$inserted.', removed: '.$removed."\n";
