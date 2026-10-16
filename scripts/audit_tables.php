<?php

// One-off: list existing tables to confirm permission tables are present.
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$tables = collect(DB::select('SHOW TABLES'))
    ->map(fn ($row) => array_values((array) $row)[0])
    ->sort()
    ->values();

echo 'TABLES ('.$tables->count()."):\n";
foreach ($tables as $t) {
    echo "  {$t}\n";
}

echo "\nPermission tables present:\n";
foreach (['roles', 'permissions', 'model_has_roles', 'model_has_permissions', 'role_has_permissions'] as $t) {
    echo "  {$t}: ".(Schema::hasTable($t) ? 'yes' : 'NO')."\n";
}
