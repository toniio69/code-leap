<?php

// One-off audit: dump roles, permissions and the role_has_permissions matrix.
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "ROLES:\n";
foreach (DB::table('roles')->orderBy('id')->get() as $r) {
    echo "  {$r->id} | {$r->name} | {$r->guard_name}\n";
}

echo "\nPERMISSIONS:\n";
foreach (DB::table('permissions')->orderBy('id')->get() as $p) {
    echo "  {$p->id} | {$p->name} | {$p->guard_name}\n";
}

echo "\nROLE_HAS_PERMISSIONS:\n";
$rows = DB::table('role_has_permissions')->get();
if ($rows->isEmpty()) {
    echo "  (empty)\n";
}
$roleNames = DB::table('roles')->pluck('name', 'id');
$permNames = DB::table('permissions')->pluck('name', 'id');
foreach ($rows as $row) {
    $role = $roleNames[$row->role_id] ?? "role#{$row->role_id}";
    $perm = $permNames[$row->permission_id] ?? "perm#{$row->permission_id}";
    echo "  {$role} => {$perm}\n";
}
echo "\nUSERS (id | email | role):\n";
foreach (DB::table('users')->orderBy('id')->get() as $u) {
    echo "  {$u->id} | {$u->email} | {$u->role}\n";
}

echo "\nMODEL_HAS_ROLES:\n";
$mhr = DB::table('model_has_roles')->get();
if ($mhr->isEmpty()) {
    echo "  (empty)\n";
}
foreach ($mhr as $row) {
    $role = $roleNames[$row->role_id] ?? "role#{$row->role_id}";
    echo "  {$row->model_type}#{$row->model_id} => {$role}\n";
}
