<?php

// One-off: dump model_has_roles and model_has_permissions per user.
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$roleNames = DB::table('roles')->pluck('name', 'id');
$permNames = DB::table('permissions')->pluck('name', 'id');

foreach (DB::table('users')->orderBy('id')->get() as $u) {
    echo "USER #{$u->id} {$u->email} (role column: {$u->role})\n";

    $roles = DB::table('model_has_roles')
        ->where('model_type', 'App\\Models\\User')
        ->where('model_id', $u->id)
        ->pluck('role_id');

    foreach ($roles as $rid) {
        echo '  has_role: '.($roleNames[$rid] ?? "role#{$rid}")."\n";
    }

    $perms = DB::table('model_has_permissions')
        ->where('model_type', 'App\\Models\\User')
        ->where('model_id', $u->id)
        ->pluck('permission_id');

    foreach ($perms as $pid) {
        echo '  has_permission: '.($permNames[$pid] ?? "perm#{$pid}")."\n";
    }

    echo "\n";
}

// Clear the Spatie permission cache so the new direct permissions take effect.
spatie_cache_clear();

function spatie_cache_clear(): void
{
    $cache = app('cache');
    $store = $cache->store(config('permission.cache.store'));
    $key = config('permission.cache.key');
    $store->forget($key);
    echo "Spatie permission cache cleared (key: {$key}).\n";
}
