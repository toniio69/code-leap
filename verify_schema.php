<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\ConnectionInterface;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
$db = app(ConnectionInterface::class);
$builder = $db->getSchemaBuilder();
$tables = ['users', 'courses', 'course_user', 'course_materials'];
foreach ($tables as $table) {
    echo $table.': '.($builder->hasTable($table) ? 'yes' : 'no').PHP_EOL;
}
$cols = [
    'users' => ['role'],
    'courses' => ['title', 'description', 'user_id', 'cover_image', 'status'],
    'course_user' => ['user_id', 'course_id', 'status'],
    'course_materials' => ['course_id', 'title', 'file_path', 'file_type', 'is_preview'],
];
foreach ($cols as $table => $columnList) {
    foreach ($columnList as $col) {
        echo $table.'.'.$col.': '.($builder->hasColumn($table, $col) ? 'yes' : 'no').PHP_EOL;
    }
}
